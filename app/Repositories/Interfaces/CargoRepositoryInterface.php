<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Cargo\CreateCargoRequest;

Interface CargoRepositoryInterface{
    public function index();
    public function getDangerStatuses();
    public function getPackagingTypes();
    public function create(CreateCargoRequest $request);
}
