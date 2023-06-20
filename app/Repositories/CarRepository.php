<?php

namespace App\Repositories;
use App\Models\Car;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Car\CreateCarRequest;


class CarRepository implements  CarRepositoryInterface {

    public function create(CreateCarRequest $request) : JsonResponse{
        try
        {
            $car = new Car($request->except(['tech_passport']));
            $car->save();

            if ($request->hasFile('tech_passport')) {
                $file = $request->file('tech_passport');

                $car->addMedia($file)->toMediaCollection('tech_passport');
            }

            return response()->json([
                'data' => $car
            ], 200);
        }
        catch (Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
