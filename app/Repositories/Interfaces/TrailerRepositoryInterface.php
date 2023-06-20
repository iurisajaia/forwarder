<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Trailer\CreateTrailerRequest;

Interface TrailerRepositoryInterface{
    public function create(CreateTrailerRequest $request);
}
