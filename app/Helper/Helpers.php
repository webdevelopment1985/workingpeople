<?php
use App\Models\Swap;
use App\Models\Users;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

function printData($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function printAndDie($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    die;
}

function debug_on()
{
    error_reporting(-1);
    ini_set('display_errors', 1);
}

function random_num($prefix, $size)
{
    $alpha_key = '';
    $keys = range('A', 'Z');

    for ($i = 0; $i < 1; $i++) {
        $alpha_key .= $prefix;
    }

    $length = $size - 2;

    $key = '';
    $keys = range(0, 9);

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $alpha_key . $key;
}
function ordinal($number)
{
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13)) {
        return $number. 'th';
    } else {
        return $number. $ends[$number % 10];
    }
}
function encrypt_decrypt($string, $action)
{
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'f-dd-aas-ass-as--a32-2';
    $secret_iv = 'f-dd-aas-ass-as--a32-2-as-a';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } elseif($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function check_valid_email($email)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.emailable.com/v1/verify?email='.$email.'&api_key=live_1fa9bd6f9cb6417551f9',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_POSTFIELDS =>'',
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    if(isset($response->state) && $response->state == 'deliverable' && $response->disposable == false) {
        return true;
    } else {
        return false;
    }
}


function convert_number($num)
{
    $x = round($num);
    $x_number_format = number_format($x);
    $x_array = explode(',', $x_number_format);
    $x_parts = array('K', 'M', 'B', 'T');
    $x_count_parts = count($x_array) - 1;
    $x_display = $x;
    $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
    $x_display .= $x_parts[$x_count_parts - 1];
    return $x_display;
}

function call_curl_request($url, $method = 'GET', $headers = [], $data = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
    }
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if ($data !== null) {
        $jsonData = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    }
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
}
function getIp()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    return request()->ip(); // it will return the server IP if the client IP is not found using this method.
}

function get_settings($key)
{
    $settings = DB::table('settings')->where('meta_key', $key)->first();
    return $settings->meta_value;
}

function getUsername($id){
    if(empty($id)){
        return '';
    }else{
        $users = Users::where('id',$id)->first(['username']);
        return $users->username ? $users->username : '';
    }
}

function shortenTransactionID($longTransactionID, $length = 10)
{
    if ($length <= 0 || $length >= strlen($longTransactionID)) {
        return $longTransactionID;
    }
    $shortTransactionID = substr($longTransactionID, 0, $length);
    return $shortTransactionID . '....' .substr($longTransactionID, -5, 5);
}

function formatNumber($amount, $decimal_place = 4)
{
    if (is_numeric($amount)) {
        if (floatval($amount) != intval($amount)) {
            return number_format((float) $amount, $decimal_place, '.', ',');
        } else {
            return number_format((int) $amount);
        }
    } else {
        return $amount;
    }
}

function truncate_number($number, $decimals)
{
    $factor = pow(10, $decimals);
    return floor($number * $factor) / $factor;
}

function showHash($hash, $number = 6){

    // Extract first and last few characters
    $start = substr($hash, 0, $number); // First 6 characters
    $end = substr($hash, -$number);     // Last 6 characters

    // Combine them with ellipsis in the middle
    $shortHash = $start . "..." . $end;

    // Output the shortened version
    return $shortHash;
}

function getQRCodeUrl($address){
    return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . $address;
}

// function admin_logs($narration,$userId,$type){
//     foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
//         if (array_key_exists($key, $_SERVER) === true) {
//             foreach (explode(',', $_SERVER[$key]) as $ip) {
//                 $ip = trim($ip); // just to be safe
//                 if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
//                     $ipaddress =  $ip;
//                 }
//             }
//         }
//     }
//     $ipaddress = request()->ip();

//     if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
//         $agent = 'Mozilla Firefox';
//     } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
//         $agent= 'Google Chrome';
//     } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false) {
//         $agent= 'Internet Explorer';
//     } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
//         $agent= 'Opera';
//     } else {
//         $agent= 'Other';
//     }

//     DB::table('admin_logs')->insert([
//         'ip' => $ipaddress,
//         'agent' =>  $agent,
//         'naration' => $narration,
//         'type'=>$type,
//         'updated' => now(),
//         'admin_id'=>$userId
//     ]);
// }


function add_user_logs($user_id, $type, $naration){
    $userDeviceInfo = getUserDeviceInfo();
    $agent = '<br> Browser : ' . $userDeviceInfo['browser'];
    $agent .= '<br> OS : ' . $userDeviceInfo['os'];
    $agent .= '<br> User Agent : ' . $userDeviceInfo['user_agent'];
    $agent .= '<br> IP Address : ' . $userDeviceInfo['ip_address'];
    $ip = $userDeviceInfo['ip_address'];
    return DB::table('user_logs')->insert([
        'ip' => $ip,
        'agent' =>  $agent,
        'naration' => $naration,
        'type'=>$type,
        'updated' => now(),
        'user_id'=>$user_id
    ]);
}

function add_admin_logs($user_id, $type, $naration){
    $userDeviceInfo = getUserDeviceInfo();
    $agent = '<br> Browser : ' . $userDeviceInfo['browser'];
    $agent .= '<br> OS : ' . $userDeviceInfo['os'];
    $agent .= '<br> User Agent : ' . $userDeviceInfo['user_agent'];
    $agent .= '<br> IP Address : ' . $userDeviceInfo['ip_address'];
    $ip = $userDeviceInfo['ip_address'];
    return DB::table('admin_logs')->insert([
        'ip' => $ip,
        'agent' =>  $agent,
        'naration' => $naration,
        'type'=>$type,
        'updated' => now(),
        'admin_id'=>$user_id
    ]);
}

function getUserDeviceInfo()
{
    $userAgent = request()->header('User-Agent');

    // Detect Browser
    if (strpos($userAgent, 'Firefox') !== false) {
        $browser = 'Firefox';
    } elseif (strpos($userAgent, 'Chrome') !== false) {
        $browser = 'Chrome';
    } elseif (strpos($userAgent, 'Safari') !== false) {
        $browser = 'Safari';
    } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
        $browser = 'Internet Explorer';
    } else {
        $browser = 'Unknown Browser';
    }

    // Detect Operating System
    if (strpos($userAgent, 'Windows NT 10.0') !== false) {
        $os = 'Windows 10';
    } elseif (strpos($userAgent, 'Windows NT 6.3') !== false) {
        $os = 'Windows 8.1';
    } elseif (strpos($userAgent, 'Windows NT 6.2') !== false) {
        $os = 'Windows 8';
    } elseif (strpos($userAgent, 'Mac OS X') !== false) {
        $os = 'Mac OS';
    } elseif (strpos($userAgent, 'Android') !== false) {
        $os = 'Android';
    } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
        $os = 'iOS';
    } else {
        $os = 'Unknown OS';
    }

    return [
        'browser' => $browser,
        'os' => $os,
        'user_agent' => $userAgent,
        'ip_address' => request()->ip()
    ];
}
