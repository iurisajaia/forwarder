<?php

namespace App\Repositories;

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
            $carData = $request->except(['tech_passport', 'id']);
            $car = Car::updateOrCreate([
                'id' => $request->input('id'),
                'user_id' => $request->user()->id,
                'driver_id' => $request->user()->id,
            ], $carData);


            if ($request->hasFile('tech_passport')) {
                $car->addMedia($request->file('tech_passport'))->toMediaCollection('tech_passport');
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


}
