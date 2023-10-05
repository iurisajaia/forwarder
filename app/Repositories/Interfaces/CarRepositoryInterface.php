<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Car\CreateCarRequest;
use Illuminate\Http\Request;

Interface CarRepositoryInterface{
    public function create(CreateCarRequest $request);
    public function makeItDefault(Request $request, int $id);
}
