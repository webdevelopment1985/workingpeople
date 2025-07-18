<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;

class ApiAccessService
{
    public function getApiAccess($postdata, $headers, $validateData)
    {
        $ipAddress = getIp();
        $allowedIps = explode(",", env('ALLOWEDIPS', '127.0.0.1'));
        // dd(getIp());
        if (in_array($ipAddress, $allowedIps)) {
            $dataSig = implode("", $validateData);
            $_nonce = $postdata['nonce'];
            $_timestamp = $postdata['timestamp'];
            $_signature = $postdata['signature'];
            $email = $postdata['email'];

            $signaturePreString = $_nonce . $_timestamp . $dataSig;

            $output = $this->matchSignature($_signature, $_timestamp, $_nonce, $validateData);

            if (!$output['res']) {
                return [
                    'res' => false,
                    'errormsg' => $output['errormsg'],
                    'code' => 400,
                    'signature_pre_string' => $signaturePreString,
                    'output' => $output
                ];
            } else {
                // Verify user in the database
                $user = User::where('email', $email)->first();
                if ($user) {
                    return [
                        'res' => true,
                        'rows' => $user,
                        'successmsg' => 'SUCCESS',
                        'code' => 200
                    ];
                } else {
                    return [
                        'res' => false,
                        'errormsg' => 'Invalid Email!',
                        'code' => 400
                    ];
                }
            }
        } else {
            return [
                'res' => false,
                'errormsg' => __('API unauthorized'),
                'code' => 410
            ];
        }
    }

    private function createSignature($receivedNonce = "", $receivedTimestamp = "", $dataArray = [])
    {
        $dataSig = implode(":", $dataArray);
        $message = $receivedNonce . ":" . $receivedTimestamp . ":" . $dataSig;
        
        $appSecret = env('APP_SIGNATURE_SECRECT');
        // dd($message,$appSecret);
        return hash_hmac('sha256', $message, $appSecret);
    }

    private function matchSignature($receivedSignature = "", $receivedTimestamp = "", $receivedNonce = "", $dataArray = [])
    {
        $appSecret = env('APP_SIGNATURE_SECRECT');

        // Check if the nonce is unique (implementing nonce validation)
        $existingNonce = DB::table('signature_nonce')
            ->where('nonce', $receivedNonce)
            ->first();

        if ($existingNonce) {
            return [
                'res' => false,
                'errormsg' => 'Invalid nonce',
                'code' => 401
            ];
        }

        // Verify the timestamp (allowing a maximum skew of 5 minutes)
        $currentTime = Carbon::now()->timestamp;
        $receivedTimestampNoEpo = $receivedTimestamp / 1000;

        // if (abs($currentTime - $receivedTimestampNoEpo) > 500) {
        //     return [
        //         'res' => false,
        //         'errormsg' => 'Invalid timestamp',
        //         'code' => 400,
        //         'currentTime' => $currentTime
        //     ];
        // }

        // Calculate the signature and compare
        $calculatedSignature = $this->createSignature($receivedNonce, $receivedTimestamp, $dataArray);

        if (!hash_equals($calculatedSignature, $receivedSignature)) {
            return [
                'res' => false,
                'errormsg' => 'Invalid signature',
                'code' => 401,
                'signature' => $calculatedSignature
            ];
        } else {
            // Store nonce to prevent replay attacks
            DB::table('signature_nonce')->insert([
                'nonce' => $receivedNonce,
                'createdAt' => now()
            ]);

            return [
                'res' => true,
                'msg' => 'Valid signature',
                'code' => 200
            ];
        }
    }
}
