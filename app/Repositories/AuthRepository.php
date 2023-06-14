<?php

namespace App\Repositories;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\CustomerDetails;
use App\Models\DriverUserDetails;
use App\Models\ForwarderDetails;
use App\Models\LegalUserDetails;
use App\Models\StandardUserDetails;
use App\Models\UserRole;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\JsonResponse;
use Twilio\Rest\Client;
use Illuminate\Http\Request;



class AuthRepository implements  AuthRepositoryInterface{

    public array $roles = [
        1 => 'standard',
        2 => 'legal',
        3 => 'forwarder',
        4 => 'driver',
        5 => 'customer'
    ];

    public function createUserDetails(string $model, $request, $id){
        $data = new $model([
            ...$request,
            'user_id' => $id
        ]);
        $data->save();
    }

    public function createUserData(CreateUserRequest $request){
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_role_id' => $request->user_role_id
        ];


        $user = User::create($data);

        if(isset($request->images)){
            foreach ($request->images as $key => $image){
                $user->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
            }
        }


        if(isset($request->standard) && $request->user_role_id == 1){
            $data = new StandardUserDetails([
                ...$request->standard,
                'user_id' => $user->id
            ]);
            $data->save();
        }

        if(isset($request->legal) && $request->user_role_id == 2){
            $data = new LegalUserDetails([
                ...$request->legal,
                'user_id' => $user->id
            ]);
            $data->save();
        }

        if(isset($request->forwarder) && $request->user_role_id == 3){
            $data = new ForwarderDetails([
                ...$request->forwarder,
                'user_id' => $user->id
            ]);
            $data->save();
        }

        if(isset($request->driver) && $request->user_role_id == 4){
            $data = new DriverUserDetails([
                ...$request->driver,
                'user_id' => $user->id
            ]);
            $data->save();
        }


        if(isset($request->customer) && $request->user_role_id == 5){
            $data = new CustomerDetails([
                ...$request->customer,
                'user_id' => $user->id
            ]);
            $data->save();
        }


        return $user;
    }

    public function createUser(CreateUserRequest $request) : JsonResponse{

        $user = $this->createUserData($request);

        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();

        $now = now();

        if($userOtp && $now->isBefore($userOtp->expire_at)){
            return $userOtp;
        }


        $code = 123456; // rand(123456, 999999);

        /* Create a New OTP */
        UserOtp::create([
            'user_id' => $user->id,
            'otp' => $code,
            'expire_at' => $now->addMinutes(10)
        ]);

//        $this->sendSms($code, $user->phone);


        $resUser = User::query()->with(['role', 'media', $this->roles[$user->user_role_id]])->findOrFail($user->id);
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user' => $resUser,
            'token' => $resUser->createToken("API TOKEN")->plainTextToken
        ], 200);

    }

    public function getLoginCode(GetLoginCodeRequest $request) : JsonResponse{
        $user = User::query()->where('phone' , $request->phone)->first();

        if(!isset($user)){
            return response()->json(['error' => 'Cannot find user'], 404);
        }

        $code = 123456; // rand(123456, 999999);

        $otp = UserOtp::create([
            'user_id' => $user->id,
            'otp' => $code,
            'expire_at' => now()->addMinutes(10)
        ]);

        return response()->json(['otp' => $otp]);
        //$this->sendSms($code, $user->phone);

    }

    public function loginUser(LoginUserRequest $request) : JsonResponse{

        $user = User::where('phone', $request->phone)->first();

        if(!isset($user)){
            return response()->json(['error' => 'Cannot find user'], 404);
        }

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
            return response()->json(['error' => 'Cannot find user'], 404);
        }
    }

    public function verifyUser(VerifyUserRequest $request) : JsonResponse{
        $userOtp  = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        if(!isset($userOtp)){
            return response()->json(['error' => 'Something went wrong'], 404);
        }

        $this->checkForOtpError($userOtp);

        $user = User::whereId($request->user_id)->first();

        if($user){

            $userOtp->update([
                'expire_at' => now()
            ]);

            $user->phone_verified_at = now();
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'User verified successfully'
            ]);
        }else{
            return response()->json(['error' => 'Cannot find user'],404);
        }
    }

    public function checkForOtpError($userOtp){
        if (!$userOtp) {
            return response()->json(['error' => 'Your OTP is not correct'], 401);
        }else if($userOtp && now()->isAfter($userOtp->expire_at)){
            return response()->json(['error' => 'Your OTP has been expired'], 401);
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
            ], $e->getCode());
        }
    }

    public function getUserRoles(): JsonResponse{
        try {
            return response()->json([
                'data' => UserRole::query()->where('is_visible' , 1)->get(),
                'status' => true
            ], 200);
        }catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function currentUser(Request $request): JsonResponse{
        try {
            $ruser = $request->user();

            if(!$ruser){
                return response()->json([
                    'error' => 'Cannot find user',
                    'status' => 401
                ]);
            }


            $user = User::query()->with(['role', 'media', $this->roles[$ruser->user_role_id]])->findOrFail($ruser->id);


            return response()->json([
                'user' => $user
            ], 200);

        }catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }



}
