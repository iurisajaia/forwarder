<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Interfaces\DriverRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\CreateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    private UserRepositoryInterface $userRepository;
    private DriverRepositoryInterface $driverRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        DriverRepositoryInterface $driverRepository,
    ){
        $this->userRepository = $userRepository;
        $this->driverRepository = $driverRepository;
    }

    public function create(CreateUserRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->createUser($request, true);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getMyDrivers(Request $request) : JsonResponse
    {
        try {
            return $this->driverRepository->getMyDrivers($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getMyCars(Request $request) : JsonResponse
    {
        try {
            return $this->driverRepository->getMyCars($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getMyTrailers(Request $request) : JsonResponse
    {
        try {
            return $this->driverRepository->getMyTrailers($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function makeCarDefault(Request $request, int $id) : JsonResponse
    {
        try {
            return $this->driverRepository->makeCarDefault($request, $id);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function makeTrailerDefault(Request $request, int $id) : JsonResponse
    {
        try {
            return $this->driverRepository->makeTrailerDefault($request, $id);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function makeDriverDefault(Request $request, int $id) : JsonResponse
    {
        try {
            return $this->driverRepository->makeDriverDefault($request, $id);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
