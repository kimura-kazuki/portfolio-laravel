<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Eloquent「厳格モード」の有効化
        // Model::shouldBeStrict(! $this->app->isProduction());

        // Preventing Lazy Loading (N+1 checker)
        Model::preventLazyLoading(! $this->app->isProduction());

        // // プロダクション環境のみに適応するため、ここで登録する
        // if ($this->app->environment('production')) {
        //     \URL::forceScheme('https');
        // }
    }
}
