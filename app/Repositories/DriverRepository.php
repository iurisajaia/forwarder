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
use App\Repositories\Interfaces\DriverRepositoryInterface;
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



class DriverRepository implements  DriverRepositoryInterface {


    public function getMyDrivers(Request $request) : JsonResponse {
        $drivers = DriverUserDetails::query()
            ->where('owner_id', $request->user()->id)
            ->with(['user'])
            ->whereHas('user', function($query){
                $query->where('phone_verified_at', '!=', null);
            })
            ->get();

        return response()->json([
            'data' => $drivers
        ], 200);
    }

    public function getMyCars(Request $request) : JsonResponse {
        $cars = Car::query()
            ->where('owner_id', $request->user()->id)
            ->get();

        return response()->json([
            'data' => $cars
        ], 200);
    }

    public function getMyTrailers(Request $request) : JsonResponse {
        $trailers = Trailer::query()
            ->where('owner_id', $request->user()->id)
            ->get();

        return response()->json([
            'data' => $trailers
        ], 200);
    }

    public function makeCarDefault(Request $request, int $id) : JsonResponse {
        $car = Car::query()
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if(!$car){
            return response()->json([
                'status' => false,
                'message' => 'Car not found'
            ], 404);
        }


        // TODO: check if car is taken for some order
        if($request->user()->isTransportCompany()){
            $request->user()->transport_company->car_id = $car->id;
            $request->user()->transport_company->save();
        }

        if($request->user()->isForwarder()){
            $request->user()->forwarder->car_id = $car->id;
            $request->user()->forwarder->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Car set as default'
        ], 200);
    }

    public function makeTrailerDefault(Request $request, int $id) : JsonResponse
    {
        $trailer = Trailer::query()
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$trailer) {
            return response()->json([
                'status' => false,
                'message' => 'Trailer not found'
            ], 404);
        }

        if($request->user()->isTransportCompany()){
            $request->user()->transport_company->trailer_id = $trailer->id;
            $request->user()->transport_company->save();
        }

        if($request->user()->isForwarder()){
            $request->user()->forwarder->trailer_id = $trailer->id;
            $request->user()->forwarder->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Trailer set as default'
        ], 200);
    }

    public function makeDriverDefault(Request $request, $id): JsonResponse{
        $driver = DriverUserDetails::query()
            ->where('owner_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$driver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver not found'
            ], 404);
        }

        if($request->user()->isTransportCompany()){
            $request->user()->transport_company->driver_id = $driver->user_id;
            $request->user()->transport_company->save();
        }

        if($request->user()->isForwarder()){
            $request->user()->forwarder->driver_id = $driver->user_id;
            $request->user()->forwarder->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Driver set as default'
        ], 200);
    }

    public function updateDriver(CreateUserRequest $request): JsonResponse{

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        $user = User::query()->findOrFail($request['id']);
        $user->update(array_filter($data));

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

        return response()->json([
            'message' => 'User Created Successfully',
            'user' => $user,
        ], 200);
    }
}
