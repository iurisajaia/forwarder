<?php

namespace App\Repositories;

use App\Http\Requests\Trailer\CreateTrailerRequest;
use App\Models\Trailer;
use App\Repositories\Interfaces\TrailerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TrailerRepository implements TrailerRepositoryInterface
{

    public function create(CreateTrailerRequest $request): JsonResponse
    {
        try {
            $trailerData = $request->except(['images', 'id']);
            $trailer = Trailer::updateOrCreate([
                'id' => $request->input('id'),
                'user_id' => $request->user()->id,
                'driver_id' => $request->user()->id,
            ], $trailerData);

            if(isset($request->images)){
                foreach ($request->images as $key => $image){
                    $trailer->addMedia($image['uri'])->toMediaCollection($image['title']);
                }
            }

            return response()->json([
                'data' => $trailer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function makeItDefault(Request $request, int $id): JsonResponse
    {
        try {
            $trailer = Trailer::query()->where('user_id', $request->user()->id)->where('is_default', true)->first();

            if ($trailer) {
                $trailer->is_default = false;
                $trailer->save();
            }
            $trailerToMakeDefault = Trailer::query()->where('id', $id)->first();
            if(!$trailerToMakeDefault){
                return response()->json([
                    'error' => 'Trailer not found'
                ], 404);
            }
            $trailerToMakeDefault->is_default = true;
            $trailerToMakeDefault->save();

            return response()->json([
                'data' => $trailerToMakeDefault
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
