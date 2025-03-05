<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendRegisteredMail;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
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
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // Event::listen(
        //     UserRegistered::class,
        //     SendRegisteredMail::class,
        // );
    }
}
