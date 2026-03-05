use App\Models\Role;

public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name'     => $request->username,
        'email'    => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    // Assign default role if one is set
    $defaultRole = Role::getDefault();
    if ($defaultRole) {
        $user->assignRole($defaultRole->name);
    }

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect()->route('dashboard');
}