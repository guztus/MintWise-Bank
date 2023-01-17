<?php

namespace App\Http\Controllers;

use App\Repositories\CryptoRepository;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;

class PortfolioController extends Controller
{
    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index(): View
    {
        return view('portfolio.index', [
            'assets' => (new PortfolioService($this->cryptoRepository))->execute(),
        ]);
    }
}
