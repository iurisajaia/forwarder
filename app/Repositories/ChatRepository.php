<?php

namespace App\Repositories;
use App\Events\Message;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Models\Message as MessageModel;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Http\JsonResponse;


class ChatRepository implements  ChatRepositoryInterface {

    public function sendMessage(SendMessageRequest $request){
        try {
            $newMessage = MessageModel::query()
                ->create($request->all())
                ->load('sender', 'receiver');

            event(new Message($newMessage));

            return $newMessage;
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show($senderId , $receiverId)
    {
        try {
            // Get the conversation between the two users
            return MessageModel::where(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
            })->orWhere(function ($query ) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
            })->with(['sender','receiver'])->get();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

    }

    public function index($senderId )
    {
        try {
            return MessageModel::where('sender_id', $senderId)
                ->orWhere(function ($query) use ($senderId) {
                    $query->where('receiver_id', $senderId);
                })
                ->with(['sender', 'receiver'])
                ->get()
                ->groupBy(function ($message) use ($senderId) {
                    if ($message->sender_id == $senderId) {
                        return $message->receiver_id;
                    } else {
                        return $message->sender_id;
                    }
                })
                ->map(function ($messages, $receiverId) {
                    $receiver = $messages->first()->receiver;
                    return [
                        'receiver' => $receiver,
                        'messages' => $messages,
                    ];
                })
                ->values()
                ->all();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

    }


}
