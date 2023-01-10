<?php

namespace App\Providers;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Services\Crypto\CryptoCoinMarketCapAPIService;
use Illuminate\Support\ServiceProvider;

class CryptoProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(CryptoServiceInterface::class, CryptoCoinMarketCapAPIService::class);
    }

    public function boot()
    {
        //
    }
}
