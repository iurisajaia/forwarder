<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CarTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;


class CarTypeController extends Controller
{

    private CarTypeRepositoryInterface $carTypeRepository;

    public function __construct(
        CarTypeRepositoryInterface $carTypeRepository,
    ){
        $this->carTypeRepository = $carTypeRepository;
    }


    public function index() : JsonResponse
    {
        return response()->json($this->carTypeRepository->all());
    }


}
