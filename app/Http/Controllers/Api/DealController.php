<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DealRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DealController extends Controller
{

    private DealRepositoryInterface $dealRepository;

    public function __construct(
        DealRepositoryInterface $dealRepository,
    ){
        $this->dealRepository = $dealRepository;
    }


    public function notifications(Request $request){
        return $this->dealRepository->notifications($request);
    }

    public function index(Request $request){
        return $this->dealRepository->index($request);
    }

    protected function acceptNotification(Request $request, $id){
        return $this->dealRepository->acceptNotification($request , $id);
    }
}
