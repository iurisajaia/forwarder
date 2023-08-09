<?php

namespace App\Repositories;

use App\Models\Carrgo;
use App\Models\CarrgoDetails;
use App\Models\CarrgoRoute;
use App\Repositories\Interfaces\CarrgoRepositoryInterface;
use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Car;


class CarrgoRepository implements CarrgoRepositoryInterface
{

    public function index(): JsonResponse{
        return response()->json(['data' => Carrgo::query()->with(['details', 'details.trailer_type', 'car_type', 'route', 'user', 'driver', 'media'])->orderByDesc('id')->get()]);
    }

    public function create(CreateCarrgoRequest $request): JsonResponse
    {
        try {

            // create carrgo
            $carrgo = new Carrgo([...$request->get('carrgo')]);
            $carrgo->user_id = $request->user()->id;

            if(isset($request->images)){
                foreach ($request->images as $key => $image){
                    if($request->id){
                        $existingMedia = $carrgo->getMedia($image['title'])->first();
                        if ($existingMedia) {
                            $existingMedia->delete();
                        }
                    }
                    $carrgo->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
                }
            }

            $carrgo->save();



            // create carrgo details
            $carrgoDetails = new CarrgoDetails($request->get('details'));
            $carrgoDetails->carrgo_id = $carrgo->id;
            $carrgoDetails->save();

            // create carrgo route
            $carrgoRoute = new CarrgoRoute($request->get('routes'));
            $carrgoRoute->carrgo_id = $carrgo->id;
            $carrgoRoute->save();

            return response()->json(['message' => 'Carrgo created successfully', 'data' => Carrgo::with(['details', 'route', 'user', 'driver'])->findOrFail($carrgo->id)]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
