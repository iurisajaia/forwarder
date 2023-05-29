<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class RsController extends Controller
{
    public function taxPayer($code) : JsonResponse {
        $client = new Client();
        try {

            $res = $client->get('https://xdata.rs.ge/TaxPayer/PublicInfo', [
                'json' => [
                    'IdentCode' =>  $code
                ]
            ]);

            if ($res->getStatusCode() === 200) {
                return response()->json(json_decode($res->getBody(), true));
            } else {
                return response()->json(['error' => 'Something went wrong']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
