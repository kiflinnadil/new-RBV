<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Juniyasyos\IamClient\Events\IamAuthenticated;
use App\Listeners\IamAuthenticatedListener;

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
        Event::listen(
            IamAuthenticated::class,
            IamAuthenticatedListener::class
        );
    }
}
