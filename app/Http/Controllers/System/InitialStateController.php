<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Utils\Response;
use Illuminate\Http\Request;

class InitialStateController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $config = Config::all();

        $response = [
            'config' => $config,
            'user' => $user,
        ];

        return new Response($request, $response);
    }
}
