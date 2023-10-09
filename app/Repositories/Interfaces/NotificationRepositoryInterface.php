<?php

namespace App\Repositories\Interfaces;
use Illuminate\Http\Request;



Interface NotificationRepositoryInterface{
    public function index(Request $request);
    public function create(array $request);
}
