<?php

namespace App\Repositories;

use App\Http\Requests\CreateUserRequest;
use App\Models\Cargo;
use App\Models\CargoDetails;
use App\Models\CargoRoute;
use App\Models\DangerStatus;
use App\Models\Location;
use App\Models\PackagingType;
use App\Models\UserContact;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Http\Requests\Cargo\CreateCargoRequest;
use App\Repositories\Interfaces\DealRepositoryInterface;
use App\Repositories\Interfaces\LocationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class LocationRepository implements LocationRepositoryInterface
{



    public function create(CreateUserRequest $request, int $userId): JsonResponse
    {
        try {

            $location = new Location();
            if($request->has('location')){
                $location['location'] = $request->get('location');
            }
            $location['user_id'] = $userId;
            $location['updated_at'] = Carbon::now()->setTimezone('Asia/Tbilisi');
            $location->save();



            return response()->json(['location' => $location]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {

            $location = Location::query()->where(['user_id' => $request->user()->id])->first();

            if(!$location){
                return response()->json([
                    'error' => 'Location not found'
                ], 404);
            }


            $location->update([
                'location' => $request->get('location'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Tbilisi')
            ]);

            return response()->json(['message' => 'location updated successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

}
