<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CreateCarRequest;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private CarRepositoryInterface $carRepository;

    public function __construct(
        CarRepositoryInterface $carRepository,
    ){
        $this->carRepository = $carRepository;
    }


    public function create(CreateCarRequest $request){
        return $this->carRepository->create($request);
    }

}
