<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        $permissions = Permission::withCount('users')->get();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }
}
