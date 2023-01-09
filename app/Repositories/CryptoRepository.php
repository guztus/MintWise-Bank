<?php

namespace App\Repositories;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Models\Collections\CoinCollection;
use Illuminate\Support\Facades\Cache;

class CryptoRepository
{
    public function __construct(CryptoServiceInterface $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function getList(): CoinCollection
    {
        if (!Cache::get('coinList')) {
            Cache::remember('coinList', 60, function () {
                return $this->cryptoService->getList();
            });
        }
        return Cache::get('coinList');
    }

    public function getSingle(string $symbol)
    {
        if (!Cache::get("Crypto$symbol")) {
            Cache::remember("Crypto$symbol", 60, function () use ($symbol) {
                return $this->cryptoService->getSingle($symbol);
            });
        }
        return Cache::get("Crypto$symbol");
    }
}
