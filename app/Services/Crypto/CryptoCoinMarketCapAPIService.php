<?php

namespace App\Services\Crypto;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Models\Coin;
use App\Models\Collections\CoinCollection;
use Illuminate\Support\Facades\Http;

class CryptoCoinMarketCapAPIService implements CryptoServiceInterface
{
    private string $currency;

    public function __construct(string $currency = 'EUR')
    {
        $this->currency = $currency;
    }

    public function getSingle(string $symbol): ?Coin
    {
        $fetchedCoin = $this->singleCoin($symbol)->data->$symbol;
        if ($fetchedCoin) {
            $fetchedCoin = $fetchedCoin[0];
        } else {
            return null;
        }

        $currency = $this->currency;
        return new Coin(
            $this->getLogo($symbol) ?? '',
            $fetchedCoin->symbol,
            $fetchedCoin->quote->$currency->price,
            $fetchedCoin->quote->$currency->percent_change_1h,
            $fetchedCoin->quote->$currency->percent_change_24h,
            $fetchedCoin->quote->$currency->percent_change_7d,
            $fetchedCoin->quote->$currency->volume_24h,
            $fetchedCoin->quote->$currency->volume_change_24h,
            $fetchedCoin->circulating_supply,
            $fetchedCoin->total_supply,
            $fetchedCoin->max_supply,
        );
    }

    public function getList(): CoinCollection
    {
        $coinList = new CoinCollection();

        $currency = $this->currency;
        $coins = $this->realCoins()->data;
        foreach ($coins as $coin) {
            $coinList->addCoin(
                new Coin(
                    $coin->logo = str_replace('64x64', '32x32', $this->getLogo($coin->symbol)) ?? '',
                    $coin->symbol,
                    $coin->quote->$currency->price,
                    $coin->quote->$currency->percent_change_1h,
                    $coin->quote->$currency->percent_change_24h,
                    $coin->quote->$currency->percent_change_7d,
                    $coin->quote->$currency->volume_24h,
                    $coin->quote->$currency->volume_change_24h,
                    $coin->circulating_supply,
                    $coin->total_supply,
                    $coin->max_supply,
                )
            );
        }
        return $coinList;
    }

    private function singleCoin(string $symbol): object
    {
        $coin = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => config('services.coinmarketcap.key'),
        ])->get("https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest", [
            'symbol' => $symbol,
            'convert' => $this->currency
        ]);
        return $coin->object();
    }

    private function dummyCoins(): object
    {
        $request = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => 'b54bcf4d-1bca-4e8e-9a24-22ff2c3d462c',
        ])->get('https://sandbox-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'start' => '1',
            'limit' => '10',
            'convert' => $this->currency,
        ]);
        return $request->object();
    }

    private function realCoins(): object
    {
        $request = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('CRYPTO_COINMARKETCAP_API_KEY'),
        ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'start' => '1',
            'limit' => '2',
            'convert' => $this->currency,
        ]);
        return $request->object();
    }

    private function getLogo(string $symbol): string
    {
        $metadata = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('CRYPTO_COINMARKETCAP_API_KEY'),
        ])->get("https://pro-api.coinmarketcap.com/v2/cryptocurrency/info", [
            'symbol' => $symbol
        ]);
        return $metadata->object()->data->$symbol[0]->logo;
    }
}
