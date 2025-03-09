<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{


        public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
        public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if the user exists
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Register new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(uniqid()), // Generate random password
                'google_id' => $googleUser->id,
                'client_id' => Str::uuid(),
            ]);
        }

        // Login the user
        Auth::login($user);

        return redirect('/dashboard'); // Redirect to dashboard
    }
}
