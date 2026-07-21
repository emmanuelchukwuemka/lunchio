<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    public function index()
    {
        $founder = $this->authorizeFounder();

        $teamMembers = $founder->teamMembers()->with('permissions')->latest()->get();

        return view('customer.team.index', [
            'teamMembers' => $teamMembers,
            'availablePermissions' => RoleSeeder::TEAM_PERMISSIONS,
        ]);
    }

    public function store(Request $request)
    {
        $founder = $this->authorizeFounder();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'permissions' => ['array'],
            'permissions.*' => [Rule::in(RoleSeeder::TEAM_PERMISSIONS)],
        ]);

        $member = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'owner_id' => $founder->id,
            'email_verified_at' => now(),
        ]);

        $member->assignRole('team_member');
        $member->syncPermissions($validated['permissions'] ?? []);

        return back()->with('status', "Team member {$member->name} created. Share their login email and password with them.");
    }

    public function updatePermissions(Request $request, User $member)
    {
        $founder = $this->authorizeFounder();

        abort_unless($member->owner_id === $founder->id, 403);

        $validated = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => [Rule::in(RoleSeeder::TEAM_PERMISSIONS)],
        ]);

        $member->syncPermissions($validated['permissions'] ?? []);

        return back()->with('status', "Permissions updated for {$member->name}.");
    }

    public function destroy(User $member)
    {
        $founder = $this->authorizeFounder();

        abort_unless($member->owner_id === $founder->id, 403);

        $member->delete();

        return back()->with('status', 'Team member removed.');
    }

    private function authorizeFounder(): User
    {
        $user = Auth::user();

        abort_if($user->isTeamMember(), 403, 'Team members cannot manage the team.');

        return $user;
    }
}
