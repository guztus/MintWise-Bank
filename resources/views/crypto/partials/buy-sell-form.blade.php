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
    <div class="card-standard flex flex-col w-1/2 center">
        @if($accounts->isEmpty())
            <div class="heading-medium"><a href="{{ route('accounts.index') }}" class="text-purple-900 underline">Open an account</a> to start trading!</div>
        @else
            <div class="flex flex-row w-1/2 center">
                <form id="buy" action="{{ route('crypto.buy', $crypto->getSymbol()) }}" method="post">
                    @csrf
                    <input name="symbol" value="{{ $crypto->getSymbol() }}" hidden>
                    <x-input-label for="asset_amount">Asset Amount</x-input-label>
                    <input class="input" id="asset_amount" name="assetAmount" type="number"
                           placeholder="{{ $crypto->getSymbol() }}"
                           step="0.000000001"
                           required
                           oninput="copyBuyForm(); fiatChangeLive()">
                    <x-input-label for="fiat_amount">FIAT Amount</x-input-label>
                    <input class="input w-1/2" id="fiat_amount" type="number" placeholder="Money Amount" step="0.01"
                           min="0.01"
                           oninput="copyBuyForm(); amountChangeLive()">
                    <x-input-label for="account">Account</x-input-label>
                    <select
                        id="account"
                        class="input mx-0"
                        name="payerAccountNumber"
                        oninput="copyBuyForm()">
                        @foreach($accounts as $account)
                            <option
                                value="{{ $account->number }}">{{ $account->label }} ({{ $account->number }}
                                ) {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                        @endforeach
                    </select>
                </form>
                <form id="sell" action="{{ route('crypto.sell', $crypto->getSymbol()) }}" method="post">
                    @csrf
                    <input name="symbol" value="{{ $crypto->getSymbol() }}" hidden>
                    <input name="assetAmount" type="hidden" placeholder="{{ $crypto->getSymbol() }}"
                           step="0.000000001"
                           required>
                    <input type="hidden" placeholder="Money Amount" step="0.01"
                           min="0.01" hidden>
                    <select
                        style="display: none"
                        form="sell"
                        class="center w-50 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="payerAccountNumber">
                        @foreach($accounts as $account)
                            <option
                                value="{{ $account->number }}">{{ $account->label }} ({{ $account->number }}
                                ) {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="flex flex-row center w-max" style="gap: 1.5em">
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
        @endif
    </div>
</div>
