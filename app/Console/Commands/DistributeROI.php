<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Carbon\Carbon;

class DistributeROI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distribute:roi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute ROI based on the percentage value from the settings table and log the transaction in the transactions table';

    /**
     * Execute the console command.
     */
  public function handle()
{
    // Fetch the ROI percentage from the settings table
    $roiPercentage = DB::table('settings')
        ->where('meta_key', 'monthly_return')
        ->value('meta_value');

    // Convert the percentage to a decimal
    $roiPercentage = $roiPercentage / 100;

    // Get the current date and determine the previous month
    $now = Carbon::now();
     $startOfPreviousMonth = $now->copy()->subMonth()->startOfMonth();
 $endOfPreviousMonth = $now->copy()->subMonth()->endOfMonth();

    // Fetch all invoices where ROI needs to be distributed
    $invoices = DB::table('invoices')->where('expire', 0)->get();

    foreach ($invoices as $invoice) {
        // Get the start date of the investment
        $startDate = Carbon::parse($invoice->created_at);
        
        // Calculate the number of active days in the previous month
         $activeDays = $startDate->between($startOfPreviousMonth, $endOfPreviousMonth)
            ? $endOfPreviousMonth->diffInDays($startDate) + 1 // Include the start date
            : $endOfPreviousMonth->diffInDays($startOfPreviousMonth) + 1; // Full month

        // Calculate the ROI based on active days
         $daysInPreviousMonth = $endOfPreviousMonth->diffInDays($startOfPreviousMonth) + 1;

       // exit;
        $roi = ($invoice->amount * $roiPercentage) * ($activeDays / $daysInPreviousMonth);

        // Fetch remaining amount using the stored procedure
        DB::statement('CALL calculate_remaining_amount(?, @remaining_amount)', [$invoice->user_id]);
        // Retrieve the output parameter
        $remainingAmount = DB::select('SELECT @remaining_amount AS remaining_amount')[0]->remaining_amount;

        if ($remainingAmount > 0) {
            $roi = min($remainingAmount, $roi);
            
            // Update the `roi` field in the invoices table
            DB::table('invoices')->where('id', $invoice->id)->update(['roi' => $roi]);

            // Increment `distributed_months`
            DB::table('invoices')->where('id', $invoice->id)->update([
                'distributed_months' => DB::raw('distributed_months + 1') // Increment the months field
            ]);

            $narration = 'ROI Payout for Invoice ID ' . $invoice->id;
            $transaction = new Transaction();
            $transaction->updateUserBalance($invoice->user_id, $roi, 0, 'USDT', $narration, 'credit', 'roi-income', 1, $invoice->id, null);

            if ($remainingAmount <= $roi) {
                DB::table('invoices')->where('expire', 0)->where('user_id', $invoice->user_id)->update(['expire' => 1]);
            }
        }
    }
}


}
