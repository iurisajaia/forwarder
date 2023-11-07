<?php

namespace App\Repositories;

use App\Enums\DealStatusEnum;
use App\Enums\OfferStatusEnum;
use App\Enums\UserRolesEnum;
use App\Http\Requests\Deal\FinishDealRequest;
use App\Http\Requests\Deal\MakeOfferRequest;
use App\Models\Currency;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Invoice as InvoiceModel;
use App\Repositories\Interfaces\DealRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Deal;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;


class DealRepository implements  DealRepositoryInterface {

    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
    ){
        $this->notificationRepository = $notificationRepository;
    }

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
                ->where('user_id' , $request->user()->id)
                ->orderByDesc('id')
                ->with(['media', 'invoice'])
                ->get();

            return response()->json([
                'data' => $deals
            ], 200);
        } catch (\Exception $e) {
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

    public function create(int $userId , int $cargoId): JsonResponse
    {
        try {
            $deal = new Deal([
                'user_id' => $userId,
                'cargo_id' => $cargoId,
            ]);
            $deal->save();

            $response = [
                'message' => 'Deal created successfully'
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function makeOffer(MakeOfferRequest $request): JsonResponse
    {
        try {
            $offer = new Offer($request->all());
            $offer->save();

            $userId = $offer['driver_id'];

            $role = $request->user()->user_role_id;

            if($role === UserRolesEnum::DRIVER->value || $role === UserRolesEnum::TRANSPORT_COMPANY->value){
                $deal = Deal::query()->where('id' , $offer['deal_id'])->first();
                $userId = $deal?->user_id;
            }


            $notificationData = [
                'title' => 'New offer',
                'body' => 'You have a new offer',
                'deal_id' => $offer['deal_id'],
                'user_id' => $userId,
                'offer_id' => $offer['id']
            ];


            $notification = new Notification($notificationData);
            $notification->save();


            return response()->json([
                'data' => 'Offer sent successfully'
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function rejectOffer($request, $id): JsonResponse{
        try {
            $offer = Offer::where('id' , $id)->first();

            if(!$offer) return response()->json(['error' => 'Cannot find the offer'], 404);

            $offer->status = OfferStatusEnum::rejected;
            $offer->save();

            return response()->json(['offer' => $offer, 'message' => 'Offer rejected successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function acceptOffer($request, $id): JsonResponse{
        try {
            $offer = Offer::where('id' , $id)->first();

            if(!$offer) return response()->json(['error' => 'Cannot find the offer'], 404);

            $deal = Deal::where('id' , $offer->deal_id)->first();

            if(!$deal) return response()->json(['error' => 'Cannot find the deal'], 404);

            if($deal->status !== DealStatusEnum::in_progress) return response()->json(['error' => 'Deal is not in progress'], 404);


            $offer->status = OfferStatusEnum::accepted;
            $offer->save();

            $deal->status = DealStatusEnum::active;
            $deal->driver_id = $offer->driver_id;
            $deal->price = $offer->price;
            $deal->save();


            return response()->json(['offer' => $offer, 'message' => 'Offer accepted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function completeDeal(FinishDealRequest $request, $id)
    {
        $deal = Deal::where('driver_id', $request->user()->id)->where('id', $id)->first();

        if(!$deal) return response()->json(['error' => 'Cannot find the deal'], 404);

        if(isset($request->images)){
            foreach ($request->images as $key => $image){
                $deal->addMedia($image['uri'])->toMediaCollection($image['title']);
            }
        }

        $deal->status = DealStatusEnum::completed;
        $deal->save();

        return response()->json(['deal' => $deal, 'message' => 'Deal completed successfully']);


    }

    public function generateInvoice(Deal $deal){
        $customer = new Buyer([
            'name'          => $deal->driver->name,
            'custom_fields' => [
                'email' => $deal->driver->email
            ],
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item)
            ->save('public');

        $newInvoice = new InvoiceModel([
            'price' => $deal->price,
            'description' => 'Invoice for deal',
            'file' => $invoice->url(),
        ]);
        $newInvoice->save();

        return $newInvoice->id;
    }

    public function finishDeal(Request $request, $id): JsonResponse
    {
        $deal = Deal::where('user_id', $request->user()->id)->with(['driver'])->where('id', $id)->first();

        if (!$deal) return response()->json(['error' => 'Cannot find the deal'], 404);

        $deal->status = DealStatusEnum::finished;
        $deal->invoice_id = $this->generateInvoice($deal);
        $deal->save();

        return response()->json(['deal' => $deal, 'message' => 'Deal finished successfully']);
    }

    public function getCurrencies(): JsonResponse{
        return response()->json(['data' => Currency::query()->get()]);
    }

}
