<?php

namespace App\Providers;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\PokemonMigrateServiceContract;
use App\Contracts\Services\PokemonServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Services\Auth\AuthService;
use App\Services\Pokemon\PokemonMigrateService;
use App\Services\Pokemon\PokemonService;
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
        $this->app->bind(PokemonMigrateServiceContract::class, PokemonMigrateService::class);
        $this->app->bind(PokemonServiceContract::class, PokemonService::class);
    }
}
