<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DealController extends Controller
{


    private function generateDummyUser()
    {
        // Replace the following with the desired user dummy object
        return [
            'id' => mt_rand(1000, 9999),
            'name' => 'User ' . mt_rand(1, 20),
            'email' => 'user' . mt_rand(1, 20) . '@example.com',
        ];
    }


    public function index() : JsonResponse {
        $dummyData = [];

        for ($i = 0; $i < 20; $i++) {
            $dummyData[] = [
                'user' => $this->generateDummyUser(),
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ];
        }
        return response()->json(['data' => $dummyData]);
    }
}
