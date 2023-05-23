<?php

namespace App\Repositories;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\JsonResponse;
use Twilio\Rest\Client;

class AuthRepository implements  AuthRepositoryInterface{

    public function createUser(CreateUserRequest $request) : JsonResponse{

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);


        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();

        $now = now();

        if($userOtp && $now->isBefore($userOtp->expire_at)){
            return $userOtp;
        }


        $code = rand(123456, 999999);

        /* Create a New OTP */
        UserOtp::create([
            'user_id' => $user->id,
            'otp' => $code,
            'expire_at' => $now->addMinutes(10)
        ]);

        $this->sendSms($code, $user->phone);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully'
        ], 200);

    }

    public function getLoginCode(GetLoginCodeRequest $request) : JsonResponse{
        $user = User::query()->where('phone' , $request->phone)->first();

        $code = rand(123456, 999999);

        UserOtp::create([
            'user_id' => $user->id,
            'otp' => $code,
            'expire_at' => now()->addMinutes(10)
        ]);

        return $this->sendSms($code, $user->phone);

    }

    public function loginUser(LoginUserRequest $request) : JsonResponse{

        $user = User::where('phone', $request->phone)->first();

        $userOtp = UserOtp::where('user_id', $user->id)->where('otp', $request->otp)->first();



        $this->checkForOtpError($userOtp);

        if($user){

            $userOtp->update([
                'expire_at' => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        }else{
            return response()->json(['error' => 'Cannot find user']);
        }
    }

    public function verifyUser(VerifyUserRequest $request) : JsonResponse{
        $userOtp   = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();


        $this->checkForOtpError($userOtp);

        $user = User::whereId($request->user_id)->first();

        if($user){

            $userOtp->update([
                'expire_at' => now()
            ]);

            $user->phone_verified_at = now();
            $user->save();

            return response()->json([
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        }else{
            return response()->json(['error' => 'Cannot find user']);
        }
    }

    public function checkForOtpError($userOtp){
        if (!$userOtp) {
            return response()->json(['error' => 'Your OTP is not correct']);
        }else if($userOtp && now()->isAfter($userOtp->expire_at)){
            return response()->json(['error' => 'Your OTP has been expired']);
        }
        return true;
    }

    public function sendSms($code,$number) : JsonResponse{
        try
        {
            $sid    = config('app.twilio')['TWILIO_ACCOUNT_SID'];
            $token  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
            $messagingServiceSid  = config('app.twilio')['MESSAGING_SERVICE_SID'];
            $twilio = new Client($sid, $token);

            $message = $twilio->messages
                ->create($number, // to
                    array(
                        "messagingServiceSid" => $messagingServiceSid,
                        "body" => "Your forwarder verification code is " . $code
                    )
                );

            return response()->json([
                'success' => $message->sid
            ]);

        }
        catch (Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
