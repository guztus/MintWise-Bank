<?php

namespace App\Providers;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Services\Crypto\CryptoCoinMarketCapAPIService;
use Illuminate\Support\ServiceProvider;

class CryptoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CryptoServiceInterface::class, CryptoCoinMarketCapAPIService::class);
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
