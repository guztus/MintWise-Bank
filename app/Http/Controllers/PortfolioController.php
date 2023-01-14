<?php

namespace App\Http\Controllers;

use App\Repositories\CryptoRepository;
use App\Services\PortfolioService;

class PortfolioController extends Controller
{
    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index()
    {
        return view('portfolio.index', [
            'assets' => (new PortfolioService($this->cryptoRepository))->execute(),
        ]);
    }
}
