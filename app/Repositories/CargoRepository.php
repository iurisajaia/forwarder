<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Models\CargoDetails;
use App\Models\CargoRoute;
use App\Models\DangerStatus;
use App\Models\PackagingType;
use App\Models\UserContact;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Http\Requests\Cargo\CreateCargoRequest;
use App\Repositories\Interfaces\DealRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class CargoRepository implements CargoRepositoryInterface
{

    private DealRepositoryInterface $dealRepository;

    public function __construct(
        DealRepositoryInterface $dealRepository,
    ){
        $this->dealRepository = $dealRepository;
    }

    public function all(): JsonResponse
    {
        $cargos = Cargo::query()->where('status', 'pending')->with(['deal','details', 'details.trailer_type', 'car_type', 'route', 'user', 'driver', 'media', 'contacts'])->orderByDesc('id')->get();
        return response()->json(['data' => $cargos]);
    }

    public function index(Request $request): JsonResponse
    {

        $cargos = Cargo::query()->where('user_id', $request->user()->id)->with(['deal','details', 'details.trailer_type', 'car_type', 'route', 'user', 'driver', 'media', 'contacts'])->orderByDesc('id')->get();
        return response()->json(['data' => $cargos]);
    }

    public function create(CreateCargoRequest $request): JsonResponse
    {
        try {


            $cargo = new Cargo([...$request->only(['date', 'car_type_id'])]);
            $cargo->user_id = $request->user()->id;

            if($request->has('images')){
                $this->addMedia($request, $cargo);
            }

            $cargo->save();

            $this->createCargoRoute($request, $cargo);
            $this->createCargoDetails($request, $cargo);

            if ($request->get('contacts')) {
                $this->createCargoContacts($request, $cargo);
            }


            $this->dealRepository->create($request->user()->id, $cargo->id);


            $response = [
                'message' => 'Cargo created successfully',
                'data' => Cargo::with(['details', 'route', 'user', 'driver', 'media', 'contacts'])->findOrFail($cargo->id)
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CreateCargoRequest $request, int $id): JsonResponse
    {
        try {

            $cargo = Cargo::findOrFail($id);
            $cargo->update($request->only(['date', 'car_type_id']));

            if($request->has('images')){
                $this->addMedia($request, $cargo);
            }
            $cargo->save();

            if($request->details){
                $details = CargoDetails::query()->where('cargo_id', $cargo->id)->first();
                $details->update($request->get('details'));
            }

            if($request->routes){
                $route = CargoRoute::query()->where('cargo_id', $cargo->id)->first();
                $route->update($request->get('routes'));
            }

//            if($cargo->contacts){
//                foreach($cargo->contacts as $contact){
//                    UserContact::query()->updateOrCreate([...$contact]);
//                }
//            }


            return response()->json($cargo);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function addMedia($request, $cargo)
    {
        if (isset($request->images)) {
            foreach ($request->images as $key => $image) {
                if ($request->id) {
                    $existingMedia = $cargo->getMedia($image['title'])->first();
                    if ($existingMedia) {
                        $existingMedia->delete();
                    }
                }
                $cargo->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
            }
        }
    }

    public function createCargoRoute($request, $cargo)
    {
        $cargoRoute = new CargoRoute($request->get('routes'));
        $cargoRoute->cargo_id = $cargo->id;
        $cargoRoute->save();
    }

    public function createCargoDetails($request, $cargo)
    {
        $details = [
            'weight' =>  intval($request->get('details')['weight']),
            'weight_type' => $request->get('details')['weight_type'],
            'width' => intval($request->get('details')['width']),
            'height' => intval($request->get('details')['height']),
            'length' => intval($request->get('details')['length']),
            'degree' => intval($request->get('details')['degree']),
            'packaging_type_id' => intval($request->get('details')['packaging_type_id']),
            'danger_status_id' => intval($request->get('details')['danger_status_id']),
            'cargo_id' => $cargo->id,
        ];


        $cargoDetails = new CargoDetails($details);
        $cargoDetails->save();

    }

    public function createCargoContacts($request, $cargo)
    {
        $contacts = [];
        foreach ($request->get('contacts') as $key => $item) {
            $contact = new UserContact($item);
            $contact->user_id = $request->user()->id;
            $contact->save();
            $contacts[] = $contact['id'];
        }
        $cargo->contacts()->sync($contacts);
    }

    public function getDangerStatuses(): JsonResponse
    {
        $dangerStatuses = DangerStatus::query()->orderByDesc('id')->get();
        return response()->json(['data' => $dangerStatuses]);
    }

    public function getPackagingTypes(): JsonResponse
    {
        $packageTypes = PackagingType::query()->orderByDesc('id')->get();
        return response()->json(['data' => $packageTypes]);
    }

}
