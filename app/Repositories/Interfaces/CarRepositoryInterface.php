<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Car\CreateCarRequest;

Interface CarRepositoryInterface{
    public function create(CreateCarRequest $request);
}
