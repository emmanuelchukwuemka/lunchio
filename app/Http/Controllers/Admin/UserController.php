<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function staff()
    {
        $staff = User::role(['admin', 'staff'])
            ->withCount(['assignedOrders as active_order_count' => function ($query) {
                $query->whereNotIn('status', [\App\Models\Order::STATUS_DELIVERED]);
            }])
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->back()->with('status', 'User created successfully.');
    }

    public function updateRole(Request $request, User $user)
    {
        // Prevent admin from accidentally removing their own admin role
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return redirect()->back()->with('status', 'You cannot change your own admin role.');
        }

        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->back()->with('status', 'User role updated successfully.');
    }
}
