<?php

namespace App\Providers;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Http\Services\CryptoLocalDatabase;
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
        $this->app->bind(CryptoServiceInterface::class, CryptoLocalDatabase::class);
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
