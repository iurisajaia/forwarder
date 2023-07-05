<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Chat\SendMessageRequest;

Interface ChatRepositoryInterface{
    public function sendMessage(SendMessageRequest $request);
    public function show($senderId , $receiverId);
    public function index($senderId);
}
