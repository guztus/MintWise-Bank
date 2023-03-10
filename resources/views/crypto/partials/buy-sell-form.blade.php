<script>
    function copyBuyForm() {
        let buyForm = document.getElementById("buy");
        let sellForm = document.getElementById("sell");
        let buyFormInputs = buyForm.getElementsByTagName("input");
        let sellFormInputs = sellForm.getElementsByTagName("input");
        for (let i = 0; i < buyFormInputs.length; i++) {
            let buyFormInput = buyFormInputs[i];
            let sellFormInput = sellFormInputs[i];
            sellFormInput.value = buyFormInput.value;
        }
        let buyFormSelect = buyForm.getElementsByTagName("select")[0];
        let sellFormSelect = sellForm.getElementsByTagName("select")[0];
        sellFormSelect.value = buyFormSelect.value;
    }

    function fiatChangeLive() {
        let inputCoinAmount = document.getElementById('asset_amount').value;
        let fiatAmount = inputCoinAmount * {{ $crypto->getPrice() }};
        fiatAmount = fiatAmount.toFixed(2);

        document.getElementById('fiat_amount').value = fiatAmount;
    }

    function amountChangeLive() {
        let inputFiatAmount = document.getElementById('fiat_amount').value;
        let coinAmount = inputFiatAmount / {{ $crypto->getPrice() }};
        coinAmount = coinAmount.toFixed(9);

        document.getElementById('asset_amount').value = coinAmount;
    }
</script>

<div class="container-fluid">
    <div class="card-standard flex flex-col w-2/5 center p-4">
        <div class="flex">
            <p class="flex-1 px-4 py-2 bottom-gray-border left">Wallet:</p>
            <p class="flex-1 px-4 py-2 bottom-gray-border right text-sm">{{ $wallet->number }}</p>
        </div>
        <div class="flex">
            <p class="flex-1 px-4 py-2 bottom-gray-border left">FIAT balance: {{ config('global.currency_symbol') }}</p>
            <p class="flex-1 px-4 py-2 bottom-gray-border right">{{ number_format($wallet->balance / 100, 2) }}</p>
        </div>
        <div class="flex flex-row w-1/2 center mt-6 items-center">
            <form id="buy" action="{{ route('crypto.buy', $crypto->getSymbol()) }}" method="post">
                @csrf

                <divZ>
                    <input name="symbol" value="{{ $crypto->getSymbol() }}" hidden>
                    <label>Amount
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                <span class="text-gray-500 sm:text-sm">{{ $crypto->getSymbol() }}</span>
                            </div>
                            <input class="input"
                                   style="padding-right: 50px"
                                   id="asset_amount"
                                   name="assetAmount"
                                   type="number"
                                   step="0.000000001"
                                   required
                                   oninput="fiatChangeLive(); copyBuyForm()">
                        </div>
                    </label>
                </divZ>

                <div>
                    <label>FIAT Amount
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">{{ config('global.currency_symbol') }}</span>
                            </div>
                            <input class="input"
                                   id="fiat_amount"
                                   type="number"
                                   step="0.01"
                                   min="0.01"
                                   oninput="amountChangeLive(); copyBuyForm()">
                        </div>
                    </label>
                </div>
            </form>
            <form id="sell" action="{{ route('crypto.sell', $crypto->getSymbol()) }}" method="post">
                @csrf
                <input name="symbol" value="{{ $crypto->getSymbol() }}" hidden>
                <input name="assetAmount" type="hidden" placeholder="{{ $crypto->getSymbol() }}"
                       step="0.000000001"
                       required>
                <input type="hidden" placeholder="Money Amount" step="0.01"
                       min="0.01" hidden>
            </form>
        </div>
        <div class="flex flex-row center mt-4 w-max gap-4">
            <div>
                <button type="submit"
                        form="buy"
                        class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                    Buy
                </button>
            </div>
            <div>
                <button type="submit"
                        form="sell"
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                    Sell
                </button>
            </div>
        </div>
    </div>
</div>
