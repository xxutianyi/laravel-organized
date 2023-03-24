<?php

use App\Models\Pivot\TeamUser;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = User::create([
            'id' => User::ROOT_ID,
            'name' => config('initial.root.user_name'),
            'mobile' => config('initial.root.user_mobile'),
            'password' => Hash::make(config('initial.root.user_password')),
            'order' => 255,
        ]);

        $team = Team::create([
            'id' => Team::ROOT_ID,
            'name' => config('app.name'),
            'order' => 255,
        ]);

        TeamUser::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'is_manager' => true,
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $user = User::find(User::ROOT_ID);
        $user->teams()->detach();
        $user->forceDelete();
        Team::find(Team::ROOT_ID)->forceDelete();
    }
};
