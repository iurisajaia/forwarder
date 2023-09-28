<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Models\CargoDetails;
use App\Models\CargoRoute;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Http\Requests\Cargo\CreateCargoRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Car;


class CargoRepository implements CargoRepositoryInterface
{

    public function index(): JsonResponse{
        return response()->json(['data' => Cargo::query()->with(['details', 'details.trailer_type', 'car_type', 'route', 'user', 'driver', 'media'])->orderByDesc('id')->get()]);
    }

    public function create(CreateCargoRequest $request): JsonResponse
    {
        try {

            $cargo = new Cargo([...$request->only(['date', 'car_type_id'])]);
            $cargo->user_id = $request->user()->id;
            $this->addMedia($request, $cargo);
            $cargo->save();

            $this->createCargoDetails($request, $cargo);
            $this->createCargoRoute($request, $cargo);

            $response = [
                'message' => 'Cargo created successfully',
                'data' => Cargo::with(['details', 'route', 'user', 'driver', 'media'])->findOrFail($cargo->id)
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function addMedia($request, $cargo){
        if(isset($request->images)){
            foreach ($request->images as $key => $image){
                if($request->id){
                    $existingMedia = $cargo->getMedia($image['title'])->first();
                    if ($existingMedia) {
                        $existingMedia->delete();
                    }
                }
                $cargo->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
            }
        }
    }

    public function createCargoRoute($request, $cargo){
        $cargoRoute = new CargoRoute($request->get('routes'));
        $cargoRoute->cargo_id = $cargo->id;
        $cargoRoute->save();
    }

    public function createCargoDetails($request, $cargo){
        $cargoDetails = new CargoDetails($request->get('details'));
        $cargoDetails->cargo_id = $cargo->id;
        $cargoDetails->save();
    }




}
