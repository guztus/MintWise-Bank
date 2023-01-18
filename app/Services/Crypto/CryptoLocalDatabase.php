<?php

namespace App\Services\Crypto;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Models\Coin;
use App\Models\Collections\CoinCollection;

class CryptoLocalDatabase implements CryptoServiceInterface
{
    public function getSingle(string $symbol): ?Coin
    {
        return new Coin(
            'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png',
            '777',
            321.21235484,
            1.8255464,
            32164,
            0.564564564,
            1.8255464,
            32164,
            8674464,
            646874687,
            48646846464,
        );
    }

    public function getList(): CoinCollection
    {
        return new CoinCollection(
            [
                new Coin('https://s2.coinmarketcap.com/static/img/coins/32x32/1.png',
                    '777',
                    321.21235484,
                    1.8255464,
                    32164,
                    0.564564564,
                    32164,
                    0.564564564,
                    8674464,
                    646874687,
                    48646846464,
                ),
                new Coin(
                    'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png',
                    '777',
                    321.21235484,
                    1.8255464,
                    32164,
                    0.564564564,
                    32164,
                    0.564564564,
                    8674464,
                    646874687,
                    48646846464,
                ),
                new Coin(
                    'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png',
                    '777',
                    321.21235484,
                    1.8255464,
                    32164,
                    0.564564564,
                    32164,
                    0.564564564,
                    8674464,
                    646874687,
                    48646846464,
                ),
                new Coin(
                    'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png',
                    '777',
                    321.21235484,
                    1.8255464,
                    32164,
                    0.564564564,
                    32164,
                    0.564564564,
                    8674464,
                    646874687,
                    48646846464,
                ),
                new Coin(
                    'https://s2.coinmarketcap.com/static/img/coins/32x32/1.png',
                    '777',
                    321.21235484,
                    1.8255464,
                    32164,
                    0.564564564,
                    32164,
                    0.564564564,
                    8674464,
                    646874687,
                    48646846464,
                )
            ]
        );
    }
}
