<?php

namespace App\Repositories;
use App\Events\Conversation;
use App\Events\Message;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Models\Message as MessageModel;
use App\Models\User;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Http\JsonResponse;


class ChatRepository implements  ChatRepositoryInterface {



    public function hasConversation($senderId, $receiverId)
    {
        return MessageModel::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->exists();
    }



    public function sendMessage(SendMessageRequest $request){
        try {

//            $hasConversation = $this->hasConversation($request->sender_id, $request->receiver_id);

            $newMessage = MessageModel::query()
                ->create($request->all())
                ->load('sender', 'receiver');

            event(new Message($newMessage));

//            if(!$hasConversation) event(new Conversation($newMessage));

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
            })->with(['sender','receiver'])->orderBy('created_at', 'ASC')->get();

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
                ->groupBy(function ($message) {
                    // Group by whether the message has a deal_id or not
                    return $message->deal_id ? 'deal_messages' : 'normal_messages';
                })
                ->map(function ($groupedMessages, $group) use ($senderId) {
                    // Further group messages within each group based on receiver_id
                    $groupedMessages = $groupedMessages->groupBy(function ($message) use ($senderId) {
                        if ($message->sender_id == $senderId) {
                            return $message->receiver_id;
                        } else {
                            return $message->sender_id;
                        }
                    });

                    // Map and process each sub-group
                    $processedMessages = $groupedMessages->map(function ($messages, $receiverId) use ($senderId) {
                        $receiver = $messages->first()->receiver;

                        // If the receiver's id is the same as the $senderId, use $receiverId instead
                        if ($receiver->id == $senderId) {
                            $receiver = User::find($receiverId);
                        }

                        return [
                            'receiver' => $receiver->toArray(),
                            'messages' => $messages->map->toArray()->values()->all(),
                        ];
                    });

                    return [
                        'group' => $group,
                        'messages' => $processedMessages->values()->all(),
                    ];
                })
                ->values();

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

    }


}
