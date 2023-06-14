<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyUserRequest;
use Illuminate\Http\Request;


Interface AuthRepositoryInterface{
    public function createUser(CreateUserRequest $request);
    public function getLoginCode(GetLoginCodeRequest $request);
    public function loginUser(LoginUserRequest $request);
    public function verifyUser(VerifyUserRequest $request);
    public function sendSms($code,$number);
    public function getUserRoles();
    public function currentUser(Request $request);
}
