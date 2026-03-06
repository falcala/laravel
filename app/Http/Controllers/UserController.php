<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;

class UserController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $roles = Role::orderBy('name')->get();

        $query = User::with('roles');

        if ($request->filled('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")
                                      ->orWhere('email', 'like', "%$s%")
                                      ->orWhere('nickname', 'like', "%$s%"));
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('content.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('content.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'nickname'        => 'nullable|string|max:60|unique:users,nickname|regex:/^[a-zA-Z0-9_\-]+$/',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6|confirmed',
            'phone'           => 'nullable|string|max:20',
            'birthday'        => 'nullable|date|before:today',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'roles'           => 'nullable|array',
        ]);

        $data = [
            'name'     => $request->name,
            'nickname' => $request->nickname ?: null,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'birthday' => $request->birthday,
        ];

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')
                ->store('avatars', 'public');
        }

        $user = User::create($data);

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('content.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles    = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        return view('content.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'nickname'        => 'nullable|string|max:60|unique:users,nickname,' . $user->id . '|regex:/^[a-zA-Z0-9_\-]+$/',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'phone'           => 'nullable|string|max:20',
            'birthday'        => 'nullable|date|before:today',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'roles'           => 'nullable|array',
        ]);

        $data = [
            'name'     => $request->name,
            'nickname' => $request->nickname ?: null,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'birthday' => $request->birthday,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')
                ->store('avatars', 'public');
        }

        $user->update($data);

        if (auth()->user()->can('roles.edit')) {
            $user->syncRoles($request->roles ?? []);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}