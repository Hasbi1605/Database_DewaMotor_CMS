<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        \Illuminate\Pagination\Paginator::useBootstrap();

        // Performance optimizations
        if (app()->environment('production')) {
            // Prevent lazy loading in production
            Model::preventLazyLoading(true);

            // Set default string length for MySQL
            Schema::defaultStringLength(191);

            // Enable query caching
            DB::enableQueryLog();
        }

        // Silently discard accessing missing attributes in production
        if (app()->environment('production')) {
            Model::preventSilentlyDiscardingAttributes(false);
        }
    }
}
