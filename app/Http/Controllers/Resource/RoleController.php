<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Utils\Response;
use App\Utils\ShowType;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index(Request $request)
    {

        $size = $request->input('pageSize');
        $current = $request->input('current');

        $data = Role::select();

        if ($size && $current) {
            return new Response($request, $data->paginate($size, ['*'], 'current', $current));
        } else {
            return new Response($request, ['data' => $data->get()]);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'permission_ids' => ['required', 'array']
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permission_ids']);

        return new Response($request, $role, "success", ShowType::SILENT, 201);

    }


    public function show(Request $request, Role $role)
    {
        return new Response($request, $role);
    }


    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'permission_ids' => ['required', 'array']
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permission_ids']);

        return new Response($request, $role);
    }


    public function destroy(Request $request, Role $role)
    {
        $role->delete();

        return new Response($request);
    }
}
