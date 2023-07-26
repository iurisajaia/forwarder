<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DealRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Models\Deal;


class DealRepository implements  DealRepositoryInterface {

    public function notifications($request) : JsonResponse{
        try {
            $deals = Deal::query()
                ->with(['user'])
                ->where('is_accepted' , 0)
                ->where('user_id' , NULL)
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'data' => $deals
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function index($request) : JsonResponse{
        try {
            $deals = Deal::query()
                ->with(['user'])
                ->where('is_accepted' , 1)
                ->where('user_id' , $request->user()->id)
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'data' => $deals
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function acceptNotification($request , $id): JsonResponse
    {
        $deal = Deal::where('id' , $id)->first();

        if(!$deal) return response()->json(['error' => 'Cannot find the deal'], 404);

        $deal->is_accepted = 1;
        $deal->user_id = $request->user()->id;
        $deal->save();

        return response()->json(['deal' => $deal, 'message' => 'Deal accepted successfully']);
    }



}
