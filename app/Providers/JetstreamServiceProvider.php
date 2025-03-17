<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Vite::prefetch(concurrency: 3);


        Fortify::authenticateUsing(function (Request $request){

            $user = User::where('email', $request->email)->first();

            if ($user &&
            Hash::check($request->password, $user->password)) {

                $accessToken = $user->generateAccessToken($user->id);
                $refreshToken = $user->generateRefreshToken($user->id);

                DB::table('refresh_tokens')->where('user_id', $user->id)->delete();
                DB::table('refresh_tokens')->insert([
                    'user_id' => $user->id,
                    'token' => $refreshToken,
                    'expires_at' => Carbon::now()->addDays(7),
                ]);

                Cookie::queue(
                    'access_token',
                    $accessToken,
                    30, // Expires in 15 minutes
                    '/',
                    null,
                    true, // Secure (Set to false for local testing)
                    true  // HTTP-only (Not accessible via JavaScript)
                );

                // Set Refresh Token (Long-lived, 7 days)
                Cookie::queue(
                    'refresh_token',
                    $refreshToken,
                    7 * 24 * 60, // Expires in 7 days
                    '/',
                    null,
                    true, // Secure
                    true  // HTTP-only
                );
            return $user;
        }

        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
