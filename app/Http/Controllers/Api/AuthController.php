<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\User;
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


    public function getLoginCode(GetLoginCodeRequest $request) : JsonResponse
    {
        try {
            return $this->authRepository->getLoginCode($request);
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

    /**
     * @OA\Get(
     *     path="/api/auth/users",
     *     @OA\Response(response="200", description="Users List")
     * )
     */
    public function getUsers(){
        return response()->json(['users' => User::query()->with(['media'])->get()]);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/user-roles",
     *     @OA\Response(response="200", description="User Roles")
     * )
     */
    public function getUserRoles() : JsonResponse{
        return response()->json($this->authRepository->getUserRoles());
    }

}
