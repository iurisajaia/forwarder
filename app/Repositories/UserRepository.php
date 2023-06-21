<?php

namespace App\Repositories;
use App\Models\Car;
use App\Models\CustomerDetails;
use App\Models\DriverUserDetails;
use App\Models\ForwarderDetails;
use App\Models\LegalUserDetails;
use App\Models\StandardUserDetails;
use App\Models\Trailer;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\UserRole;
use App\Models\UserOtp;
use Twilio\Rest\Client;
use App\Models\User;



class UserRepository implements  UserRepositoryInterface{

    private CarRepositoryInterface $carRepository;

    public function __construct(
        CarRepositoryInterface $carRepository,
    ){
        $this->carRepository = $carRepository;
    }

    public array $roles = [
        1 => ['standard'],
        2 => ['legal'],
        3 => ['forwarder'],
        4 => ['driver', 'driver.car' ,'driver.trailer'],
        5 => ['customer']
    ];


    public function createUserData(CreateUserRequest $request, $id = null){
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_role_id' => $request->user_role_id
        ];

        $user = User::updateOrCreate(['id' => $id], $data);

        if (isset($request['languages'])) {
            $languages = Language::whereIn('id', $request['languages'])->get();
            $user->languages()->sync($languages);
        }

        if(isset($request->images)){
            foreach ($request->images as $key => $image){
                if($request->id){
                    $existingMedia = $user->getMedia($image['title'])->first();
                    if ($existingMedia) {
                        $existingMedia->delete();
                    }
                }
                $user->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
            }
        }

        if($data['user_role_id'] == 1 && isset($request->standard)){
            StandardUserDetails::updateOrCreate(['user_id' => $user->id], $request->standard);
        }
        if($data['user_role_id'] == 2 && isset($request->legal)){
            LegalUserDetails::updateOrCreate(['user_id' => $user->id], $request->legal);
        }
        if($data['user_role_id'] == 3 && isset($request->forwarder)){
            ForwarderDetails::updateOrCreate(['user_id' => $user->id], $request->forwarder);
        }
        if($data['user_role_id'] == 4 && isset($request->driver)){
            $this->createDriverType($request, $user);
        }
        if($data['user_role_id'] == 5 && isset($request->customer)){
            CustomerDetails::updateOrCreate(['user_id' => $user->id], $request->customer);
        }

        return $user;
    }

    public function createDriverType($request, $user){

        $driver = DriverUserDetails::updateOrCreate(['user_id' => $user->id], [
            'telegram' => $request->driver['telegram'],
            'whatsapp' => $request->driver['whatsapp'],
            'viber' => $request->driver['viber'],
            'referral_code' => $request->driver['referral_code'],
            'iban' => $request->driver['iban'],
            'user_id' => $user->id
        ]);

        if ($request->hasFile('drivers_license')) {
            $file = $request->file('drivers_license');
            $driver->addMedia($file)
                ->toMediaCollection('drivers_license');
        }
        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $driver->addMedia($file)
                ->toMediaCollection('passport');
        }


        if(isset($request->driver['car'])){
            $this->createCar($request,$driver);
        }

        if(isset($request->driver['trailer'])){
            $this->createTrailer($request,$driver);
        }
    }

    public function createCar($request, $driver){
        if(isset($request->driver['car']['id'])){
            $car = Car::findOrFail($request->driver['car']['id']);
        }else{
            $car = new Car();
        }
        $car->number = $request->driver['car']['number'];
        $car->title = $request->driver['car']['title'];
        $car->model = $request->driver['car']['model'];
        $car->identification_number = $request->driver['car']['identification_number'];
        $car->car_type_id = $request->driver['car']['car_type_id'];
        $car->save();

        $driver->car_id = $car->id;
        $driver->save();

        if ($request->hasFile('tech_passport')) {
            $file = $request->file('tech_passport');

            $car->addMedia($file)
                ->toMediaCollection('tech_passport');
        }
    }

    public function createTrailer($request, $driver){
        if(isset($request->driver['trailer']['id'])){
            $trailer = Trailer::findOrFail($request->driver['trailer']['id']);
        }else{
            $trailer = new Trailer();
        }
        $trailer->number = $request->driver['trailer']['number'];
        $trailer->title = $request->driver['trailer']['title'];
        $trailer->model = $request->driver['trailer']['model'];
        $trailer->identification_number = $request->driver['trailer']['identification_number'];
        $trailer->trailer_type_id = $request->driver['trailer']['trailer_type_id'];
        $trailer->save();

        $driver->trailer_id = $trailer->id;
        $driver->save();

        if ($request->hasFile('tech_passport')) {
            $file = $request->file('tech_passport');
            $trailer->addMedia($file)
                ->toMediaCollection('tech_passport');
        }
    }

    public function createUser(CreateUserRequest $request, $id = null) : JsonResponse{

        $user = $this->createUserData($request, $id);


        $code = 123456; // rand(123456, 999999);

        $data = [
            'user_id' => $user->id,
            'otp' => $code,
            'expire_at' => now()->addMinutes(10)
        ];

        UserOtp::updateOrCreate(['user_id' => $user->id], $data);

//        $this->sendSms($code, $user->phone);


        $resUser = User::query()->with(['role', 'media', ...$this->roles[$user->user_role_id]])->findOrFail($user->id);
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user' => $resUser,
            'token' => $resUser->createToken("API TOKEN")->plainTextToken
        ], 200);

    }

    public function deleteUser(int $id) : JsonResponse{
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully', 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user.'], 500);
        }

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

//        $userOtp = UserOtp::where('user_id', $user->id)->where('otp', $request->otp)->first();

//        $this->checkForOtpError($userOtp);

        if($user){

//            $userOtp->update([
//                'expire_at' => now()
//            ]);

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


            $user = User::query()->with(['role', 'media', ...$this->roles[$ruser->user_role_id]])->findOrFail($ruser->id);


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
