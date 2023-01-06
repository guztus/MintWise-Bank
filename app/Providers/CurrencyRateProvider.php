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
            $array = json_decode($json, TRUE);
            $array = $array['Currencies']['Currency'];

            $currencies = [];
            for ($i=0; $i<count($array); $i++) {
                $currencies[$i] ['id']= $array[$i]['ID'];
                $currencies[$i] ['rate']= (float)$array[$i]['Rate'];
                $i++;
            }

            Cache::remember('currencies', 60, function () use ($currencies) {
                return $currencies;
            });
        }
    }
}
