<?php

namespace App\Http\Requests;

use App\Http\Interfaces\CryptoServiceInterface;
use App\Repositories\CryptoRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CryptoSaleRequest extends FormRequest
{
    protected float $minimumAmount;

    public function __construct(CryptoServiceInterface $cryptoService, CryptoRepository $cryptoRepository)
    {
        parent::__construct();
        $this->cryptoService = $cryptoService;
        $this->cryptoRepository = $cryptoRepository;
    }

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        Cache::rememberForever('latestPrice', function () {
            return $this->cryptoService->getSingle($this->symbol)->getPrice();
        });

        $this->minimumAmount =
            0.01
            / (Cache::get('latestPrice')
                * Cache::get('currencies')
                [auth()->user()->accounts->where('number', $this->payerAccountNumber)->first()->currency]
            );
        if (strpos($this->minimumAmount, "-")) {
            $this->minimumAmount =
                number_format($this->minimumAmount, (int)substr($this->minimumAmount, (strpos($this->minimumAmount, "-") + 1)));
        }

        return [
            'symbol' =>
                [
                    'required',
                ],
            'payerAccountNumber' =>
                [
                    'required',
                    'exists:accounts,number',
                    'in:' . Auth::user()->accounts->pluck('number')->implode(','),
                ],
            'assetAmount' =>
                [
                    'required',
                    'numeric',
                    'min:' . $this->minimumAmount,
                ],
        ];
    }

    public function messages()
    {
        return [
            'assetAmount.min' => "Minimum amount is $this->minimumAmount $this->symbol",
        ];
    }
}
