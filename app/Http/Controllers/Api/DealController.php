<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\FinishDealRequest;
use App\Http\Requests\Deal\MakeOfferRequest;
use App\Repositories\Interfaces\DealRepositoryInterface;
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

    protected function makeOffer(MakeOfferRequest $request){
        return $this->dealRepository->makeOffer($request);
    }

    protected function rejectOffer(Request $request, $id){
        return $this->dealRepository->rejectOffer($request, $id);
    }

    protected function acceptOffer(Request $request, $id){
        return $this->dealRepository->acceptOffer($request, $id);
    }

    protected function completeDeal(FinishDealRequest $request, $id){
        return $this->dealRepository->completeDeal($request, $id);
    }

    protected function finishDeal(Request $request, $id){
        return $this->dealRepository->finishDeal($request, $id);
    }

    protected function getCurrencies(Request $request){
        return $this->dealRepository->getCurrencies($request);
    }
}
