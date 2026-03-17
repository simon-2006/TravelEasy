<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('view-account-overview', function (User $user): bool {
            return $user->canViewAccountOverview();
        });

        Gate::define('manage-dashboard', function (User $user): bool {
            return $user->canManageDashboard();
        });
    }
}
