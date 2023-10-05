<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Trailer\CreateTrailerRequest;
use Illuminate\Http\Request;

Interface TrailerRepositoryInterface{
    public function create(CreateTrailerRequest $request);
    public function makeItDefault(Request $request, int $id);

}
