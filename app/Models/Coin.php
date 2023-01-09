<?php

namespace App\Models;

class Coin
{
    private string $logo;
    private string $symbol;
    private float $price;
    private float $percent_change_24h;
    private float $volume_24h;
    private float $volume_change_24h;
    private float $circulating_supply;
    private float $total_supply;
    private ?float $max_supply;

    public function __construct(
        string $logo,
        string $symbol,
        float  $price,
        float  $percent_change_24h,
        float  $volume_24h,
        float  $volume_change_24h,
        float  $circulating_supply,
        float  $total_supply,
        ?float  $max_supply,
    )
    {
        $this->logo = $logo;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->percent_change_24h = $percent_change_24h;
        $this->volume_24h = $volume_24h;
        $this->volume_change_24h = $volume_change_24h;
        $this->circulating_supply = $circulating_supply;
        $this->total_supply = $total_supply;
        $this->max_supply = $max_supply;
    }

    public function __toString(): string
    {
        return $this->symbol;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPercentChange24h(): float
    {
        return $this->percent_change_24h;
    }

    public function getVolume24h(): float
    {
        return $this->volume_24h;
    }

    public function getVolumeChange24h(): float
    {
        return $this->volume_change_24h;
    }

    public function getCirculatingSupply(): float
    {
        return $this->circulating_supply;
    }

    public function getTotalSupply(): float
    {
        return $this->total_supply;
    }

    public function getMaxSupply(): ?float
    {
        return $this->max_supply;
    }
}
