<?php

namespace Workbench\App\Providers;

use Workbench\App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

final class WorkbenchServiceProvider extends ServiceProvider
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
        Config::set('auth.providers.users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        Gate::before(function ($user, $ability) {
            return ($user->id == env('SUPER_ADMIN_ID')) ? true : null;
        });
    }
}
