<?php

namespace App\Http\Services;

use App\Http\Interfaces\CryptoServiceInterface;

class CryptoLocalDatabase implements CryptoServiceInterface
{
    public function getSingle(string $symbol): object
    {
        $coin = new \stdClass();
        $coin->quote = new \stdClass();
        $coin->quote->USD = new \stdClass();

        $coin->logo = 'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png';
        $coin->symbol = '777';
        $coin->quote->USD->price = 321.21235484;
        $coin->quote->USD->percent_change_24h = 1.8255464;
        $coin->quote->USD->volume_24h = 32164;
        $coin->quote->USD->volume_change_24h = 0.564564564;
        $coin->circulating_supply = 8674464;
        $coin->total_supply = 646874687;
        $coin->max_supply = 48646846464;

        return $coin;
    }

    public function getList(): array
    {
        $coin1 = new \stdClass();
        $coin1->quote = new \stdClass();
        $coin1->quote->USD = new \stdClass();

        $coin1->logo = 'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png';
        $coin1->symbol = '777';
        $coin1->quote->USD->price = 321.21235484;
        $coin1->quote->USD->percent_change_24h = 1.8255464;
        $coin1->quote->USD->volume_24h = 32164;
        $coin1->quote->USD->volume_change_24h = 0.564564564;
        $coin1->circulating_supply = 8674464;
        $coin1->total_supply = 646874687;
        $coin1->max_supply = 48646846464;

        $coin2 = new \stdClass();
        $coin2->quote = new \stdClass();
        $coin2->quote->USD = new \stdClass();

        $coin2->logo = 'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png';
        $coin2->symbol = 'YOYO';
        $coin2->quote->USD->price = 2.5678;
        $coin2->quote->USD->percent_change_24h = 98.48464;
        $coin2->quote->USD->volume_24h = 32164;
        $coin2->quote->USD->volume_change_24h = 0.564564564;
        $coin2->circulating_supply = 8674464;
        $coin2->total_supply = 646874687;
        $coin2->max_supply = 48646846464;

        $coin3 = new \stdClass();
        $coin3->quote = new \stdClass();
        $coin3->quote->USD = new \stdClass();

        $coin3->logo = 'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png';
        $coin3->symbol = 'ANA';
        $coin3->quote->USD->price = 153545.212354865464;
        $coin3->quote->USD->percent_change_24h = 3.8255464;
        $coin3->quote->USD->volume_24h = 32164;
        $coin3->quote->USD->volume_change_24h = 3.78564564;
        $coin3->circulating_supply = 8674464;
        $coin3->total_supply = 646874687;
        $coin3->max_supply = 48646846464;

        $coin4 = new \stdClass();
        $coin4->quote = new \stdClass();
        $coin4->quote->USD = new \stdClass();

        $coin4->logo = 'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png';
        $coin4->symbol = 'ASDE';
        $coin4->quote->USD->price = 321.21235484;
        $coin4->quote->USD->percent_change_24h = 1.8255464;
        $coin4->quote->USD->volume_24h = 32164;
        $coin4->quote->USD->volume_change_24h = 0.978564564;
        $coin4->circulating_supply = 8674464;
        $coin4->total_supply = 646874687;
        $coin4->max_supply = 48646846464;

        return [
            $coin1,
            $coin2,
            $coin3,
            $coin4
        ];
    }
}
