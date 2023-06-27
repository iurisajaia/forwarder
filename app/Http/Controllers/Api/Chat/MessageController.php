<?php

namespace App\Http\Controllers\Api\Chat;

use App\Events\Message;
use App\Models\Message as MessageModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function showConversation($senderId , $receiverId)
    {
        // Get the conversation between the two users
        $conversation = MessageModel::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query ) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->with(['sender','receiver'])->get();

        return response()->json(['conversations' => $conversation], 200);
    }


    public function sendMessage(Request $request)
    {
        // Create a new message
        $message = new MessageModel([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);
        $message->save();

        $newMessage = MessageModel::query()->with(['sender', 'receiver'])->findOrFail($message->id);

        event(new Message($newMessage));

        return response()->json(['success' => true], 200);
    }
}
