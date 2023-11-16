<?php

namespace App\Providers;

use App\Contracts\AuthServiceContract;
use App\Contracts\UserServiceContract;
use App\Services\Auth\AuthService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(AuthServiceContract::class, AuthService::class);
    }
}
