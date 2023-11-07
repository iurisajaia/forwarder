<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateDriverFreeTimeRequest;
use App\Http\Requests\VerifyUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


Interface DriverRepositoryInterface{
    public function getMyDrivers(Request $request) : JsonResponse;
    public function getMyCars(Request $request) : JsonResponse;
    public function getMyTrailers(Request $request) : JsonResponse;
    public function makeCarDefault(Request $request, int $id) : JsonResponse;
    public function makeTrailerDefault(Request $request, int $id) : JsonResponse;
    public function makeDriverDefault(Request $request, int $id) : JsonResponse;
    public function updateDriver(CreateUserRequest $request) : JsonResponse;

}
