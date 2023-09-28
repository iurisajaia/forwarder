<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Cargo\CreateCargoRequest;

Interface CargoRepositoryInterface{
    public function index();
    public function create(CreateCargoRequest $request);
}
