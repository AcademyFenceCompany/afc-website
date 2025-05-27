<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Services\UPSService;
use Illuminate\Support\Facades\View;

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
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        } 
        DB::listen(function ($query) {
            \Log::info($query->sql);
            \Log::info($query->bindings);
            \Log::info($query->time);
        });
        Paginator::useBootstrap();

        // Share $majCategories with the header partial
        View::composer('partials.header', function ($view) {
            $majCategories = DB::table('majorcategories')
                                ->where('enabled', 1)
                                ->orderBy('id') // Assuming 'name' column exists for ordering
                                ->get();
            $view->with('majCategories', $majCategories);
        });
    }
}
