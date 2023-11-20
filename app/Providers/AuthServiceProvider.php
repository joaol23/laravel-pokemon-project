<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Opcodes\LogViewer\Facades\LogViewer;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        LogViewer::auth(function ($request) {
            return App::environment("local");
        });

        Gate::define('viewApiDocs', function (User $user) {
            return $user->isAdmin();
        });
    }
}
