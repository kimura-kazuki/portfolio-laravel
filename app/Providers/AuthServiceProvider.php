<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Enums\UserRole;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('viewLogViewer', function (?User $user) {
            // return (Auth::check() && $user->role == (UserRole::SystemAdmin)->value);
            return true;
        });

        Gate::define('all', function ($user) {
            return true;
        });

        Gate::define('system-admin', function ($user) {
            return ($user->role == (UserRole::SystemAdmin)->value);
        });

        Gate::define('admin', function ($user) {
            return ($user->role == (UserRole::Admin)->value);
        });
    }
}
