<?php

namespace App\Services;

use App\Repositories\CryptoRepository;

class PortfolioService
{
    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function execute()
    {
        return auth()->user()->assets->map(function ($asset) {
            $asset->current_price = $this->cryptoRepository->getSingle($asset->symbol)->getPrice();
            return $asset;
        });
    }
}
