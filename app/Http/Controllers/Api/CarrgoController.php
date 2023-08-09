<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use App\Repositories\Interfaces\CarrgoRepositoryInterface;

class CarrgoController extends Controller
{

    private CarrgoRepositoryInterface $carrgoRepository;

    public function __construct(
        CarrgoRepositoryInterface $carrgoRepository,
    ){
        $this->carrgoRepository = $carrgoRepository;
    }

    public function index(){
        return $this->carrgoRepository->index();
    }

    public function create(CreateCarrgoRequest $request): JsonResponse {
        return $this->carrgoRepository->create($request);
    }
}
