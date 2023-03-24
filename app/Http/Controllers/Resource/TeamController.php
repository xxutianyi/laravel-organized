<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Pivot\TeamUser;
use App\Models\Team;
use App\Utils\Response;
use App\Utils\ShowType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{

    public function index(Request $request)
    {

        $size = $request->input('pageSize');
        $current = $request->input('current');

        $data = Team::select()->orderBy('order', 'desc');

        foreach (Team::$filterable as $item) {
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
            'parent_id' => ['required', 'exists:teams,id'],
        ]);

        return new Response($request, Team::create($validated), "success", ShowType::SILENT, 201);

    }


    public function show(Request $request, Team $team)
    {
        return new Response($request, $team);
    }


    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'parent_id' => ['required', 'exists:teams,id', Rule::notIn([$team->id]),],
        ]);

        $team->update($validated);

        return new Response($request, $team);
    }


    public function destroy(Request $request, Team $team)
    {

        Team::where('parent_id', $team->id)->update(['parent_id' => $team->parent_id]);
        TeamUser::where('team_id', $team->id)->update(['team_id' => $team->parent_id]);

        $team->delete();

        return new Response($request);
    }
}
