<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\cargo\CreatecargoRequest;
use App\Repositories\Interfaces\CargoRepositoryInterface;

class CargoController extends Controller
{

    private CargoRepositoryInterface $cargoRepository;

    public function __construct(
        CargoRepositoryInterface $cargoRepository,
    ){
        $this->cargoRepository = $cargoRepository;
    }

    public function index(){
        return $this->cargoRepository->index();
    }

    public function create(CreateCargoRequest $request): JsonResponse {
        return $this->cargoRepository->create($request);
    }
}
