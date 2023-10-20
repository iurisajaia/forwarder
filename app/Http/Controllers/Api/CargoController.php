<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cargo\CreateCargoRequest;
use App\Repositories\Interfaces\CargoRepositoryInterface;

class CargoController extends Controller
{

    private CargoRepositoryInterface $cargoRepository;

    public function __construct(
        CargoRepositoryInterface $cargoRepository,
    ){
        $this->cargoRepository = $cargoRepository;
    }

    public function all(){
        return $this->cargoRepository->all();
    }

    public function index(Request $request){
        return $this->cargoRepository->index($request);
    }

    public function create(CreateCargoRequest $request): JsonResponse {
        return $this->cargoRepository->create($request);
    }

    public function getDangerStatuses(){
        return $this->cargoRepository->getDangerStatuses();
    }

    public function getPackagingTypes(){
        return $this->cargoRepository->getPackagingTypes();
    }
}
