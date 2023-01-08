<?php

namespace App\Http\Interfaces;

use App\Models\Coin;
use App\Models\Collections\CoinCollection;

interface CryptoServiceInterface
{
    public function getSingle(string $symbol): ?Coin;
    public function getList(): CoinCollection;
}
