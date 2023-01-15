<?php

namespace App\Services;

use App\Repositories\CryptoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PortfolioService
{
    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function execute(): Collection
    {
        return Auth::user()->assets->map(function ($asset) {
            $asset->current_price = $this->cryptoRepository->getSingle($asset->symbol)->getPrice();
            return $asset;
        });
    }
}
