<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate([
            'email' => $socialUser->getEmail(),
        ], [
            'name' => $socialUser->getName() ?? $socialUser->getNickname(),
            'password' => bcrypt(Str::random(24)),
        ]);

        if (!$user->hasRole(['admin', 'editor', 'reader'])) {
            $user->assignRole('reader');
        }

        Auth::login($user);
        return redirect('/');
    }
}
