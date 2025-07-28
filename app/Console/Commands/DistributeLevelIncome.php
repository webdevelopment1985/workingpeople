<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\JoiningHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DistributeLevelIncome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribute:level_income';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute level income based on invoices.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $invoices = DB::table('invoices')
            ->where('expire', 0)
            ->where('user_id', '!=', 176)
            ->where('created_at', '<=', $lastMonthEnd) // Get records up to last month's end
            ->get();

        foreach ($invoices as $transaction) {
            // Calculate the distribution amount (1% of the invoice amount)
            $distributionAmount = ($transaction->amount * 1) / 100;

            // Call a function to distribute this amount to 5 levels
            self::distributeToFiveLevels($transaction->id, $transaction->user_id, $distributionAmount, $transaction->created_at);
        }

        //\Log::info('distribute:level_income[DistributeLevelIncomeLATEST]');
    }

    public static function distributeToFiveLevels($invoiceid, $userId, $distributionAmount, $startDate)
    {
        // Define the distribution matrix for levels
        $matrix = [
            1 => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 100],
            2 => [5 => 0, 4 => 0, 3 => 0, 2 => 40, 1 => 60],
            3 => [5 => 0, 4 => 0, 3 => 20, 2 => 30, 1 => 50],
            4 => [5 => 0, 4 => 10, 3 => 20, 2 => 30, 1 => 40],
            5 => [5 => 10, 4 => 15, 3 => 20, 2 => 25, 1 => 30],
        ];

        $results = JoiningHistory::where('user_id', $userId) // Condition for user_id in joining_history
            ->where('parent_user_id', '!=', 1)
            ->where('parent_user_id', '!=', 176)
            // ->where('parent_user_id','!=', 173)
            ->whereHas('forUser', function ($query) {
                $query->where('is_paid', 1); // Condition for users.is_paid
                $query->select('id', 'username', 'name', 'email', 'created_at');
            })
            ->with('forUser') // Load related user data
            ->orderBy('level', 'asc')
            ->limit(5)
            ->get();

        if (count($results) > 0) {
            // Get the current date and determine the previous month
            $now = Carbon::now();
            $startOfPreviousMonth = $now->copy()->subMonth()->startOfMonth();
            $endOfPreviousMonth = $now->copy()->subMonth()->endOfMonth();

            // Calculate active days in the previous month
            $activeDays = Carbon::parse($startDate)->between($startOfPreviousMonth, $endOfPreviousMonth)
                ? $endOfPreviousMonth->diffInDays(Carbon::parse($startDate)) + 1 // Include the start date
                : $endOfPreviousMonth->diffInDays($startOfPreviousMonth) + 1; // Full month

            // Total days in the previous month
            $daysInPreviousMonth = $endOfPreviousMonth->diffInDays($startOfPreviousMonth) + 1;

            // Adjust the distribution amount based on active days
            $adjustedDistributionAmount = ($distributionAmount * $activeDays) / $daysInPreviousMonth;

            // Example of accessing data
            $key = 1;
            foreach ($results as $joiningHistory) {
                $percent = $matrix[count($results)][$key];
                $amount = ($percent / 100) * $adjustedDistributionAmount;

                if ($joiningHistory->parent_user_id == 176 || $userId == 176) {
                    break;
                }
                // Call the stored procedure and fetch the output parameter
                //DB::statement('CALL calculate_remaining_amount(?, @remaining_amount)', [$joiningHistory->parent_user_id]);
                // Retrieve the output parameter
                // $remainingAmount = DB::select('SELECT @remaining_amount AS remaining_amount')[0]->remaining_amount;

                //if ($remainingAmount > 0) {
                $amount =  $amount;
                if ($amount > 0) {
                    $narration = 'Level Income added from Level ' . $key . ' user ' . $joiningHistory->User->username . ' for invoice #' . $invoiceid;
                    $transaction = new Transaction();
                    $transaction->updateUserBalance($joiningHistory->parent_user_id, $amount, 0, 'USDT', $narration, 'credit', 'level-income', 1, $invoiceid, null);
                    $key++;
                }
                // }


            }
        }
        return;
    }
}
