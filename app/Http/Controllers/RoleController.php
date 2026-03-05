<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Database\Seeders\PermissionSeeder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionSeeder as PermissionSeederAlias;

class RoleController extends Controller
{
    public function index()
    {
        //abort_unless(auth()->user()->can('roles.view'), 403);
        $roles = Role::with('permissions')->withCount('users')->paginate(10);
        return view('content.roles.index', compact('roles'));
    }

    public function create()
    {
        //abort_unless(auth()->user()->can('roles.create'), 403);
        $modules = \Database\Seeders\PermissionSeeder::$modules;
        $actions = \Database\Seeders\PermissionSeeder::$actions;
        return view('content.roles.create', compact('modules', 'actions'));
    }

    public function store(Request $request)
    {
        //abort_unless(auth()->user()->can('roles.create'), 403);

        $request->validate([
            'name'        => 'required|string|unique:roles,name|max:100',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        $role->syncPermissions($request->permissions ?? []);

        if ($request->boolean('is_default')) {
            $role->setAsDefault();
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        //abort_unless(auth()->user()->can('roles.edit'), 403);
        $modules         = \Database\Seeders\PermissionSeeder::$modules;
        $actions         = \Database\Seeders\PermissionSeeder::$actions;
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('content.roles.edit', compact('role', 'modules', 'actions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        //abort_unless(auth()->user()->can('roles.edit'), 403);

        $request->validate([
            'name'        => 'required|string|max:100|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        if ($request->boolean('is_default')) {
            $role->setAsDefault();
        } elseif ($role->is_default) {
            $role->update(['is_default' => false]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        //abort_unless(auth()->user()->can('roles.delete'), 403);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}