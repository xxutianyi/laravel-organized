<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Pivot\TeamUser;
use App\Models\User;
use App\Utils\Response;
use App\Utils\ShowType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $size = $request->input('pageSize');
        $current = $request->input('current');

        $data = User::select()->orderBy('order', 'desc');

        foreach (User::$filterable as $item) {
            $search = $request->input($item);
            $data->where($item, 'like', "%$search%");
        }

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
            'mobile' => ['required_without:email'],
            'email' => ['required_without:mobile'],
        ]);

        return new Response($request, User::create($validated), "success", ShowType::SILENT, 201);
    }


    public function show(Request $request, User $user)
    {
        return new Response($request, $user);
    }


    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'mobile' => ['required_without:email'],
            'email' => ['required_without:mobile'],
        ]);

        $user->update($validated);

        return new Response($request, $user);
    }


    public function destroy(Request $request, User $user)
    {
        TeamUser::where('user_id', $user->id)->delete();

        $user->delete();

        return new Response($request);
    }
}
