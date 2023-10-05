<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trailer\CreateTrailerRequest;
use App\Repositories\Interfaces\TrailerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    private TrailerRepositoryInterface $trailerRepository;

    public function __construct(
        TrailerRepositoryInterface $trailerRepository,
    ){
        $this->trailerRepository = $trailerRepository;
    }


    public function create(CreateTrailerRequest $request){
        return $this->trailerRepository->create($request);
    }

    public function makeItDefault(Request $request, int $id) : JsonResponse
    {
        return $this->trailerRepository->makeItDefault($request, $id);
    }
}
