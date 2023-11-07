<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImageController extends Controller
{
    public function delete(Request $request): JsonResponse
    {
        try {
            $media = Media::find($request->input('id'));
            $media->model->deleteMedia($media->id);

            return response()->json([
                'status' => true,
                'message' => 'Image deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
