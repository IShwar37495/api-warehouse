<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;


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

        // Generate Access & Refresh Tokens
        $accessToken = $user->generateAccessToken($user->id);
        $refreshToken = $user->generateRefreshToken($user->id);

        // Store Refresh Token in DB (remove old tokens)
        DB::table('refresh_tokens')->where('user_id', $user->id)->delete();
        DB::table('refresh_tokens')->insert([
            'user_id' => $user->id,
            'token' => $refreshToken,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        // Set Cookies for Access & Refresh Tokens
        Cookie::queue('access_token', $accessToken, 30, '/', null, true, true);
        Cookie::queue('refresh_token', $refreshToken, 7 * 24 * 60, '/', null, true, true);


        Auth::login($user);

        return redirect('/dashboard');
}
}
