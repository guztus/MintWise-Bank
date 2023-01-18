<?php

namespace App\Models\Collections;

use App\Models\Coin;

class CoinCollection
{
    private string $timestamp = '';
    private array $coins = [];

    public function __construct(array $coins = [])
    {
        foreach ($coins as $coin) {
            $this->addCoin($coin);
        }
    }

    public function addTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function addCoin(Coin $coin): void
    {
        $this->coins[] = $coin;
    }

    public function getCoins(): array
    {
        return $this->coins;
    }
}
