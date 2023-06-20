<?php

namespace App\Repositories;
use App\Http\Requests\UserType\CreateDriverUserRequest;
use App\Http\Requests\UserType\CreateLegalUserRequest;
use App\Http\Requests\UserType\CreateStandardUserRequest;
use App\Models\CustomerDetails;
use App\Models\DriverUserDetails;
use App\Models\ForwarderDetails;
use App\Models\LegalUserDetails;
use App\Models\StandardUserDetails;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Repositories\Interfaces\UserTypeRepositoryInterface;


class UserTypeRepository implements  UserTypeRepositoryInterface {

    private CarRepositoryInterface $carRepository;

    public function __construct(
        CarRepositoryInterface $carRepository,
    ){
        $this->carRepository = $carRepository;
    }

    public function createStandardUser(CreateStandardUserRequest $request, int $user_id){
        return StandardUserDetails::updateOrCreate(['user_id' => $user_id], $request->all());
    }
    public function createLegalUser(CreateLegalUserRequest $request, int $user_id){
        return LegalUserDetails::updateOrCreate(['user_id' => $user_id], $request->all());
    }
    public function createForwarderUser(CreateLegalUserRequest $request, int $user_id){
        return ForwarderDetails::updateOrCreate(['user_id' => $user_id], $request->all());
    }
    public function createCustomerUser(CreateLegalUserRequest $request, int $user_id){
        return CustomerDetails::updateOrCreate(['user_id' => $user_id], $request->all());
    }
    public function createDriverUser($request, int $user_id){
        $driver = DriverUserDetails::updateOrCreate(['user_id' => $user_id], $request->except('car', 'trailer'));

        if($request->car){
            $car = $this->carRepository->create($request->car);
            $driver->car_id = $car->data->id;
            $driver->save();
        }
        return $driver;

    }






}
