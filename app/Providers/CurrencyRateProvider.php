<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Cache::get('currencies')) {
            $xml = simplexml_load_file('https://www.bank.lv/vk/ecb.xml');
            $json = json_encode($xml);
            $rawCurrencies = json_decode($json, TRUE);
            $rawCurrencies = $rawCurrencies['Currencies']['Currency'];

            $currencies = [];

            $currencies [] =
                [
                    'id' => 'EUR',
                    'rate' => 1
                ];

            for ($i = 0; $i < count($rawCurrencies); $i++) {
                $currencies [] =
                    [
                        'id' => $rawCurrencies[$i]['ID'],
                        'rate' => (float)$rawCurrencies[$i]['Rate']
                    ];
            }

            Cache::remember('currencies', 60, function () use ($currencies) {
                return $currencies;
            });
        }
    }
}
