<?php

namespace App\Providers;

use App\Http\Controllers\AccountController;
use App\Http\Services\CurrencyRateService;
use Illuminate\Support\ServiceProvider;

class CurrencyRateProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AccountController::class, function ($app) {
            return new AccountController($app->make(CurrencyRateService::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
