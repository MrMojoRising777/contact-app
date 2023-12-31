<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFour();

        // DEBUGGING QUERIES
        // if (config('app.debug')) {  // IF APP_DEBUG inside .env = true
        //     DB::listen(fn ($query) => Log::info($query->sql, $query->bindings, $query->time));
        // }
    }
}
