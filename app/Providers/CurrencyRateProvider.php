<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CurrencyRateProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        if (!Cache::get('currencies')) {
            $xml = simplexml_load_file('https://www.bank.lv/vk/ecb.xml');
            $rawCurrencies = json_decode(json_encode($xml), TRUE);
            $rawCurrencies = $rawCurrencies['Currencies']['Currency'];

            $currencies = [];
            $currencies ['EUR'] = 1;
            foreach ($rawCurrencies as $currency) {
                $currencies [$currency['ID']] = (float)$currency['Rate'];
            }

            Cache::remember('currencies', 60, function () use ($currencies) {
                return $currencies;
            });
        }
    }
}
