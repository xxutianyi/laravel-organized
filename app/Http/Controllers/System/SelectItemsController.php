<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SelectItemsController extends Controller
{
    public function users(Request $request)
    {
        $data = User::select(['id', 'name'])->get();

        return new Response($request, $data);
    }

    public function teams(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['tree', 'flat'])],
            'id' => ['nullable', 'exists:teams']
        ]);

        $data = match ($validated['type']) {
            'tree' => Team::select()->find($validated['id'] ?? Team::ROOT_ID),
            'flat' => Team::select()->orderBy('order', 'desc')->get(),
        };

        return new Response($request, $data);

    }
}
