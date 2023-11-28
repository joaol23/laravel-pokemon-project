<?php

namespace App\Providers;

use App\Contracts\Repository\PokemonRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\Repositories\Pokemon\PokemonRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
        $this->app->singleton(PokemonRepositoryContract::class, PokemonRepository::class);
    }
}
