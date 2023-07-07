<?php

namespace App\Repositories;
use App\Models\CarType;
use App\Models\TrailerType;
use App\Repositories\Interfaces\CarTypeRepositoryInterface;
use App\Repositories\Interfaces\TrailerTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TrailerTypeRepository implements  TrailerTypeRepositoryInterface {

    public function all() : JsonResponse{

        $trailerTypes = TrailerType::query()->get();

        return response()->json([
            'status' => true,
            'data' => $trailerTypes
        ], 200);
    }


}
