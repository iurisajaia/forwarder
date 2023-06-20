<?php

namespace App\Repositories;
use App\Http\Requests\Trailer\CreateTrailerRequest;
use App\Models\Trailer;
use App\Repositories\Interfaces\TrailerRepositoryInterface;
use Illuminate\Http\JsonResponse;


class TrailerRepository implements  TrailerRepositoryInterface {

    public function create(CreateTrailerRequest $request) : JsonResponse{
        try
        {
            $trailerData = $request->except(['tech_passport', 'id']);
            $trailer = Trailer::updateOrCreate(['id' => $request->input('id')], $trailerData);

            if ($request->hasFile('tech_passport')) {
                $trailer->addMedia($request->file('tech_passport'))->toMediaCollection('tech_passport');
            }

            return response()->json([
                'data' => $trailer
            ], 200);
        }
        catch (Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
