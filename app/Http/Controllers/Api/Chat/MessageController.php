<?php

namespace App\Http\Controllers\Api\Chat;

use App\Events\Message;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Models\Message as MessageModel;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    private ChatRepositoryInterface $chatRepository;

    public function __construct(
        ChatRepositoryInterface $chatRepository,
    ){
        $this->chatRepository = $chatRepository;
    }

    public function index($senderId) : JsonResponse
    {
        return response()->json(['data' => $this->chatRepository->index($senderId)], 200);
    }

    public function show($senderId , $receiverId) : JsonResponse
    {
        return response()->json(['data' => $this->chatRepository->show($senderId, $receiverId)], 200);
    }



    public function sendMessage(SendMessageRequest $request) : JsonResponse
    {
        return response()->json(['data' => $this->chatRepository->sendMessage($request)], 200);
    }
}
