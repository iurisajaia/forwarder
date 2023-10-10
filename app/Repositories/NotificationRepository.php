<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationRepository implements NotificationRepositoryInterface
{


    public function index(Request $request)
    {
        $notifications = Notification::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->with(['deal', 'user'])
            ->get();

        return response()->json([
            'data' => $notifications
        ], 200);
    }

    public function create(array $request): JsonResponse
    {
        $notification = new Notification($request);
        $notification->save();

        // send notification to user
        return response()->json(['message' => 'Notification created successfully']);
    }

}