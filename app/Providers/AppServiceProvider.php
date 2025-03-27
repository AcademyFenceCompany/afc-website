<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Services\UPSService;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UPSService::class, function ($app) {
            return new UPSService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') === 'local') {
            URL::forceScheme('http');
        } else {
            URL::forceScheme('https');
        }
        DB::listen(function ($query) {
            \Log::info($query->sql);
            \Log::info($query->bindings);
            \Log::info($query->time);
        });
        Paginator::useBootstrap();

    }
}
