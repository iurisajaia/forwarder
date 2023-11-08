<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Cargo\CreateCargoRequest;
use Illuminate\Http\Request;

Interface CargoRepositoryInterface{
    public function all(Request $request);
    public function getDangerStatuses();
    public function getPackagingTypes();
    public function index(Request $request);
    public function create(CreateCargoRequest $request);
    public function update(CreateCargoRequest $request, int $id);
}
