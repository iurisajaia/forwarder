<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TrailerTypeRepositoryInterface;
use App\Repositories\TrailerTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrailerTypeController extends Controller
{
    private TrailerTypeRepositoryInterface $trailerTypeRepository;

    public function __construct(
        TrailerTypeRepository $trailerTypeRepository,
    ){
        $this->trailerTypeRepository = $trailerTypeRepository;
    }


    public function index() : JsonResponse
    {
        return response()->json($this->trailerTypeRepository->all());
    }


}
