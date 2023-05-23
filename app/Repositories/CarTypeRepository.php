<?php

namespace App\Repositories;
use App\Models\CarType;
use App\Repositories\Interfaces\CarTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CarTypeRepository implements  CarTypeRepositoryInterface {

    public function all() : JsonResponse{

        $carTypes = CarType::query()->get();

        return response()->json([
            'status' => true,
            'data' => $carTypes
        ], 200);
    }


}
