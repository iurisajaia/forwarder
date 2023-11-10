<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;

Interface LocationRepositoryInterface{
    public function create(CreateUserRequest $request, int $userId);
    public function update(Request $request);
}
