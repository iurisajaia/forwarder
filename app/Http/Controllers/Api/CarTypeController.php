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

    /**
     * @OA\Get(
     *     path="/api/car-types",
     *     @OA\Response(response="200", description="Car Types")
     * )
     */
    public function index() : JsonResponse
    {
        return response()->json($this->carTypeRepository->all());
    }


}
