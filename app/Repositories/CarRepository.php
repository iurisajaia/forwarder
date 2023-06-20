<?php

namespace App\Repositories;
use App\Models\Car;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Car\CreateCarRequest;


class CarRepository implements  CarRepositoryInterface {

    public function create(CreateCarRequest $request) : JsonResponse{
        try {
            $carData = $request->except(['tech_passport','id']);

            $car = Car::updateOrCreate(['id' => $request->input('id')], $carData);

            if ($request->hasFile('tech_passport')) {
                $car->addMedia($request->file('tech_passport'))->toMediaCollection('tech_passport');
            }

            return response()->json([
                'data' => $car
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
