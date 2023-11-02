<?php

namespace App\Repositories;

use App\Enums\UserRolesEnum;
use App\Models\Car;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Car\CreateCarRequest;
use Illuminate\Http\Request;

class CarRepository implements CarRepositoryInterface
{

    public function create(CreateCarRequest $request): JsonResponse
    {
        try {

            if(!$request->id && $this->checkCarNumber($request->input('number'))){
                return response()->json([
                    'error' => 'Car with this number already exists'
                ], 400);
            }

            $carData = $request->except(['images', 'id']);
            $isDefault = Car::where('user_id', $request->user()->id)->where('is_default', true)->first();
            $car = Car::updateOrCreate([
                'id' => $request->input('id'),
                'user_id' => $request->user()->id,
                'driver_id' => $request->user()->id,
                'is_default' => !$isDefault
            ], $carData);


            if(isset($request->images)){
                foreach ($request->images as $image){
                    $car->addMedia($image['uri'])->toMediaCollection($image['title']);
                }
            }

            if($request->user()->isTransportCompany() ){
                if(!$request->user()->transport_company->car_id){
                    $request->user()->transport_company->car_id = $car->id;
                    $request->user()->transport_company->save();
                }
            }

            if($request->user()->isForwarder()){
                if(!$request->user()->forwarder->car_id){
                    $request->user()->forwarder->car_id = $car->id;
                    $request->user()->forwarder->save();
                }
            }

            return response()->json([
                'data' => $car
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function makeItDefault(Request $request, int $id): JsonResponse
    {
        try {
            $car = Car::where('user_id', $request->user()->id)->where('is_default', true)->first();
            if ($car) {
                $car->is_default = false;
                $car->save();
            }
            $carToMakeDefault = Car::findOrFail($id);
            $carToMakeDefault->is_default = true;
            $carToMakeDefault->save();

            return response()->json([
                'data' => $carToMakeDefault
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function checkCarNumber(string $number){
        return Car::where('number', $number)->first();
    }


}
