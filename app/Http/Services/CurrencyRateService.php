<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Cache;

class CurrencyRateService
{
    public function __construct()
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
