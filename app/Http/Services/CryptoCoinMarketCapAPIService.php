<?php

namespace App\Http\Services;

use App\Http\Interfaces\CryptoServiceInterface;
use Illuminate\Support\Facades\Http;

class CryptoCoinMarketCapAPIService implements CryptoServiceInterface
{

    public function getSingle(string $symbol): object
    {
        $coin = $this->singleCoin($symbol);
        $coin->data->$symbol[0]->logo =$this->getLogo($symbol);
        return $coin->data->$symbol[0];
    }

    public function getList(): array
    {
        $coinList = [];

        $coins = $this->realCoins()->data;
//        $coins = $this->dummyCoins()->data;
        foreach ($coins as $coin) {
            $coin->logo = str_replace('64x64', '32x32', $this->getLogo($coin->symbol));
//            $coin->logo = 'https://logo.chainbit.xyz/' . $coin->symbol;
            $coinList [] = $coin;
        }
        return $coinList;
    }

    private function singleCoin(string $symbol)
    {
        $coin = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('CRYPTO_COINMARKETCAP_API_KEY'),
        ])->get("https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest", [
            'symbol' => $symbol
        ]);
        return $coin->object();
    }

    private function dummyCoins()
    {
        $request = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => 'b54bcf4d-1bca-4e8e-9a24-22ff2c3d462c',
        ])->get('https://sandbox-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'start' => '1',
            'limit' => '10',
            'convert' => 'USD',
        ]);
        return $request->object();
    }

    private function realCoins()
    {
        $request = Http::withHeaders([
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => env('CRYPTO_COINMARKETCAP_API_KEY'),
        ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'start' => '1',
            'limit' => '2',
            'convert' => 'USD',
        ]);
        return $request->object();
    }

    private function getLogo(string $symbol)
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
