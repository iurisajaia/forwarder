<?php

namespace App\Repositories\Interfaces;


Interface DealRepositoryInterface{
    public function index($request);
    public function notifications($request);
    public function acceptNotification($request , $id);
}
