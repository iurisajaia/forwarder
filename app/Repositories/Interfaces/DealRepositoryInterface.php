<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Deal\FinishDealRequest;
use App\Http\Requests\Deal\MakeOfferRequest;
use Illuminate\Http\Request;

Interface DealRepositoryInterface{
    public function index($request);
    public function getCurrencies();
    public function notifications($request);
    public function rejectOffer($request, $id);
    public function acceptOffer($request, $id);
    public function finishDeal(Request $request, $id);
    public function acceptNotification($request , $id);
    public function create(int $userId, int $cargoId);
    public function makeOffer(MakeOfferRequest $request);
    public function completeDeal(FinishDealRequest $request, $id);
}
