<?php

namespace App\Providers;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\PokemonExternalServiceContract;
use App\Contracts\Services\PokemonMigrateServiceContract;
use App\Contracts\Services\PokemonServiceContract;
use App\Contracts\Services\PokemonTypesServiceContract;
use App\Contracts\Services\UserPokemonServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Services\Auth\AuthService;
use App\Services\Pokemon\PokemonExternalService;
use App\Services\Pokemon\PokemonMigrateService;
use App\Services\Pokemon\PokemonService;
use App\Services\Pokemon\PokemonTypesService;
use App\Services\User\UserPokemonService;
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
        $this->registerAuthServices();
        $this->registerPokemonServices();
        $this->app->bind(UserPokemonServiceContract::class, UserPokemonService::class);
    }

    private function registerPokemonServices(): void
    {
        $this->app->bind(PokemonTypesServiceContract::class, PokemonTypesService::class);
        $this->app->bind(PokemonServiceContract::class, PokemonService::class);
        $this->app->bind(PokemonMigrateServiceContract::class, PokemonMigrateService::class);
        $this->app->bind(PokemonExternalServiceContract::class, PokemonExternalService::class);
    }

    private function registerAuthServices(): void
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(AuthServiceContract::class, AuthService::class);
    }
}
