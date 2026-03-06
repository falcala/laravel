<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'      => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password'  => null,
            ]
        );

        // If user already existed but has no google_id, link it
        if (!$user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        // Assign default role on first registration via Google
        if ($user->wasRecentlyCreated) {
            $defaultRole = Role::getDefault();
            if ($defaultRole) {
                $user->assignRole($defaultRole->name);
            }
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }
}
