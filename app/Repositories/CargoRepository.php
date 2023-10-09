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

    public function index(Request $request): JsonResponse
    {

        $cargos = Cargo::query()->where('user_id', $request->user()->id)->with(['details', 'details.trailer_type', 'car_type', 'route', 'user', 'driver', 'media', 'contacts'])->orderByDesc('id')->get();
        return response()->json(['data' => $cargos]);
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
        $cargoDetails = new CargoDetails($request->get('details'));
        $cargoDetails->cargo_id = $cargo->id;
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
