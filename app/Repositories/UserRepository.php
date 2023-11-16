<?php

namespace App\Repositories;

use App\Http\Requests\UpdateDriverFreeTimeRequest;
use App\Models\Car;
use App\Models\DriverUserDetails;
use App\Models\ForwarderDetails;
use App\Models\LegalUserDetails;
use App\Models\StandardUserDetails;
use App\Models\Trailer;
use App\Models\TransportCompanyDetails;
use App\Repositories\Interfaces\LocationRepositoryInterface;
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


class UserRepository implements UserRepositoryInterface
{

    private CarRepositoryInterface $carRepository;
    private LocationRepositoryInterface $locationRepository;

    public function __construct(
        CarRepositoryInterface $carRepository,
        LocationRepository     $locationRepository
    )
    {
        $this->carRepository = $carRepository;
        $this->locationRepository = $locationRepository;
    }


    public array $roles = [
        1 => ['standard', 'location',],
        2 => ['legal', 'location', 'cars', 'trailers', 'cars.media', 'trailers.media', 'cars.type', 'trailers.type'],
        3 => ['forwarder', 'location', 'cars', 'trailers', 'cars.media', 'trailers.media', 'cars.type', 'trailers.type', 'drivers', 'drivers.user', 'drivers.user.media', 'forwarder.car', 'forwarder.trailer', 'forwarder.driver'],
        4 => ['driver', 'location', 'cars', 'trailers', 'cars.media', 'trailers.media', 'cars.type', 'trailers.type'],
        5 => ['transport_company', 'location', 'cars', 'trailers', 'cars.media', 'trailers.media', 'cars.type', 'trailers.type', 'drivers', 'drivers.user', 'drivers.user.media', 'transport_company.car', 'transport_company.trailer', 'transport_company.driver']
    ];


    public function createUserData(CreateUserRequest $request, $hasOwner = false)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_role_id' => $request->user_role_id,
            'personal_number' => $request->personal_number,
        ];

        if ($request->user() && !$hasOwner) {
            $user = User::query()->findOrFail($request->user()->id);
            $user->update(array_filter($data));
        } else {
            $user = User::query()->create($data);
        }

        if (isset($request['languages'])) {
            $languages = Language::whereIn('id', $request['languages'])->get();
            $user->languages()->sync($languages);
        }

        if (isset($request->images)) {
            foreach ($request->images as $key => $image) {
                if ($request->id) {
                    $existingMedia = $user->getMedia($image['title'])->first();
                    if ($existingMedia) {
                        $existingMedia->delete();
                    }
                }
                $user->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
            }
        }

        if ($data['user_role_id'] == 1 && isset($request->standard)) {
            StandardUserDetails::updateOrCreate(['user_id' => $user->id], $request->standard);
        }
        if ($data['user_role_id'] == 2 && isset($request->legal)) {
            LegalUserDetails::updateOrCreate(['user_id' => $user->id], $request->legal);
        }
        if ($data['user_role_id'] == 3 && isset($request->forwarder)) {
            ForwarderDetails::updateOrCreate(['user_id' => $user->id], $request->forwarder);
        }
        if ($data['user_role_id'] == 4 && isset($request->driver)) {
            $this->createDriverType($request, $user, $hasOwner);
        }
        if ($data['user_role_id'] == 5 && isset($request->transport_company)) {
            TransportCompanyDetails::updateOrCreate(['user_id' => $user->id], $request->transport_company);
        }

        return $user;
    }

    public function createDriverType($request, $user, $hasOwner = false)
    {

        $driver = DriverUserDetails::updateOrCreate(['user_id' => $user->id], [
            'telegram' => $request->driver['telegram'] ?? '',
            'whatsapp' => $request->driver['whatsapp'] ?? '',
            'viber' => $request->driver['viber'] ?? '',
            'referral_code' => $request->driver['referral_code'] ?? '',
            'iban' => $request->driver['iban'] ?? '',
            'user_id' => $user->id,
            'owner_id' => $hasOwner ? $request->user()->id : null
        ]);
        $driver->save();

        if ($hasOwner) {
            if ($request->user()->isTransportCompany() && !$request->user()->transport_company->driver_id) {
                $request->user()->transport_company->driver_id = $driver->id;
                $request->user()->transport_company->save();
            }

            if ($request->user()->isForwarder() && !$request->user()->forwarder->driver_id) {
                $request->user()->forwarder->driver_id = $driver->id;
                $request->user()->forwarder->save();
            }
        }

        if (isset($request->driver['car'])) {
            $this->createCar($request, $driver);
        }

        if (isset($request->driver['trailer'])) {
            $this->createTrailer($request, $driver);
        }
    }

    public function createCar($request, $driver)
    {
        if (isset($request->driver['car']['id'])) {
            $car = Car::findOrFail($request->driver['car']['id']);
        } else {
            $car = new Car();
        }
        $car->number = $request->driver['car']['number'] ?? '';
        $car->title = $request->driver['car']['title'] ?? '';
        $car->model = $request->driver['car']['model'] ?? '';
        $car->identification_number = $request->driver['car']['identification_number'] ?? '';
        $car->car_type_id = $request->driver['car']['car_type_id'];
        $car->user_id = $driver->user_id;
        $car->driver_id = $driver->user_id;
        $car->is_default = true;

        if (isset($request->driver['car']['images'])) {
            foreach ($request->driver['car']['images'] as $image) {
                $car->addMedia($image['uri'])->toMediaCollection($image['title']);
            }
        }
        $car->save();

    }

    public function createTrailer($request, $driver)
    {
        if (isset($request->driver['trailer']['id'])) {
            $trailer = Trailer::findOrFail($request->driver['trailer']['id']);
        } else {
            $trailer = new Trailer();
        }
        $trailer->number = $request->driver['trailer']['number'] ?? '';
        $trailer->title = $request->driver['trailer']['title'] ?? '';
        $trailer->model = $request->driver['trailer']['model'] ?? '';
        $trailer->identification_number = $request->driver['trailer']['identification_number'] ?? '';
        $trailer->trailer_type_id = $request->driver['trailer']['trailer_type_id'];
        $trailer->user_id = $driver->user_id;
        $trailer->driver_id = $driver->user_id;
        $trailer->is_default = true;

        if (isset($request->driver['trailer']['images'])) {
            foreach ($request->driver['trailer']['images'] as $key => $image) {
                $trailer->addMedia($image['uri'])->toMediaCollection($image['title']);
            }
        }
        $trailer->save();
    }

    public function createUser(CreateUserRequest $request, $hasOwner = false): JsonResponse
    {

        $user = $this->createUserData($request, $hasOwner);

        $this->locationRepository->create($request, $user->id);

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

    public function updateUser(CreateUserRequest $request): JsonResponse
    {

        $user = $this->createUserData($request);

        $resUser = User::query()->with(['role', 'media', ...$this->roles[$user->user_role_id]])->findOrFail($user->id);
        return response()->json([
            'status' => true,
            'message' => 'User Updated Successfully',
            'user' => $resUser,
        ], 200);

    }

    public function updateDriverFreeTime(UpdateDriverFreeTimeRequest $request): JsonResponse
    {

        $user = DriverUserDetails::updateOrCreate(['user_id' => $request->user()->id], $request->except(['_method']));

        $resUser = User::query()->with(['role', 'media', ...$this->roles[$request->user()->user_role_id]])->findOrFail($request->user()->id);
        return response()->json([
            'status' => true,
            'message' => 'Driver Updated Successfully',
            'user' => $resUser,
        ], 200);

    }

    public function deleteUser(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully', 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user.'], 500);
        }

    }

    public function getLoginCode(GetLoginCodeRequest $request): JsonResponse
    {
        $user = User::query()->where('phone', $request->phone)->first();

        if (!isset($user)) {
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

    public function loginUser(LoginUserRequest $request): JsonResponse
    {

        $user = User::where('phone', $request->phone)->first();
        if (!isset($user)) {
            return response()->json(['error' => 'Cannot find user'], 404);
        }

//        $userOtp = UserOtp::where('user_id', $user->id)->where('otp', $request->otp)->first();

//        $this->checkForOtpError($userOtp);

        if ($user) {

//            $userOtp->update([
//                'expire_at' => now()
//            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } else {
            return response()->json(['error' => 'Cannot find user'], 404);
        }
    }

    public function verifyUser(VerifyUserRequest $request): JsonResponse
    {
        $userOtp = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        if (!isset($userOtp)) {
            return response()->json(['error' => 'Something went wrong'], 404);
        }

        $this->checkForOtpError($userOtp);

        $user = User::whereId($request->user_id)->first();

        if ($user) {

            $userOtp->update([
                'expire_at' => now()
            ]);

            $user->phone_verified_at = now();
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'User verified successfully'
            ]);
        } else {
            return response()->json(['error' => 'Cannot find user'], 404);
        }
    }

    public function checkForOtpError($userOtp)
    {
        if (!$userOtp) {
            return response()->json(['error' => 'Your OTP is not correct'], 401);
        } else if ($userOtp && now()->isAfter($userOtp->expire_at)) {
            return response()->json(['error' => 'Your OTP has been expired'], 401);
        }
        return true;
    }

    public function sendSms($code, $number): JsonResponse
    {
        try {
            $sid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
            $token = config('app.twilio')['TWILIO_AUTH_TOKEN'];
            $messagingServiceSid = config('app.twilio')['MESSAGING_SERVICE_SID'];
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

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function getUserRoles(): JsonResponse
    {
        try {
            return response()->json([
                'data' => UserRole::query()->where('is_visible', 1)->get(),
                'status' => true
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function currentUser(Request $request): JsonResponse
    {
        try {
            $ruser = $request->user();

            if (!$ruser) {
                return response()->json([
                    'error' => 'Cannot find user',
                    'status' => 401
                ]);
            }


            $user = User::query()->with(['role', 'media', 'languages', ...$this->roles[$ruser->user_role_id]])->findOrFail($ruser->id);


            return response()->json([
                'user' => $user
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function getDrivers(Request $request): JsonResponse
    {
        try {
            $drivers = User::query()->where('user_role_id', 4)
                ->orWhere('user_role_id', 5)
                ->with(['role', 'media', 'languages', ...$this->roles[4], ...$this->roles[5]])
                ->get();

            return response()->json([
                'drivers' => $drivers
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
