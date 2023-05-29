<?php

namespace App\Http\Controllers;

use Symfony\Component\Yaml\Yaml;
class SwaggerController extends Controller
{
    public function swaggerJson()
    {
        return view('swagger');
    }
}
