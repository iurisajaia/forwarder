<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'otp', 'expire_at'];


//    public function sendSMS($receiverNumber)
//    {
//        $code = mt_rand(100000, 999999);
//
//        try {
//
//            $account_sid = getenv("TWILIO_ACCOUNT_SID");
//            $auth_token = getenv("TWILIO_AUTH_TOKEN");
//            $twilio_number = getenv("TWILIO_FROM");
//
//            $client = new Client($account_sid, $auth_token);
//            $message = $client->messages
//                ->create($receiverNumber, // to
//                    array(
//                        "messagingServiceSid" => "MG0cbd10777946291769b16956c58ad156",
//                        "body" => "Your verification code is " . $code
//                    )
//                );
//
//            info('SMS Sent Successfully.');
//
//        } catch (Exception $e) {
//            info("Error: ". $e->getMessage());
//        }
//    }
}
