<?php

namespace App\Http\Controllers;

use App\Utils\Response;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function __invoke(Request $request)
    {
        return new Response($request, [], config('app.name'));
    }
}
