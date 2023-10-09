<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
    ){
        $this->notificationRepository = $notificationRepository;
    }

    public function index(Request $request){
        return $this->notificationRepository->index($request);
    }
}
