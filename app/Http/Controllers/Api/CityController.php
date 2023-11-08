<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(): JsonResponse{
        $cities = City::query()->get();
        return response()->json(['data' => $cities]);
    }
}
