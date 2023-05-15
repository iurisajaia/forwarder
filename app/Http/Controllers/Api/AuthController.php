<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    private AuthRepositoryInterface $authRepository;

    public function __construct(
        AuthRepositoryInterface $authRepository,
    ){
        $this->authRepository = $authRepository;
    }

    public function createUser(CreateUserRequest $request) : JsonResponse
    {
        try {
            return $this->authRepository->createUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginUser(LoginUserRequest $request) : JsonResponse
    {
        try {
            return $this->authRepository->loginUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifyUser(VerifyUserRequest $request) : JsonResponse
    {
        try {
            return $this->authRepository->verifyUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
