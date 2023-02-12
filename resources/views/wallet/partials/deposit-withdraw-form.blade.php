<script>
    function copyBuyForm() {
        let buyForm = document.getElementById("deposit");
        let sellForm = document.getElementById("withdraw");
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
</script>

<p class="heading my-3">Deposit or withdraw FIAT ({{ config('global.currency_code') }})</p>


<form method="POST" id="deposit" action="/wallet-deposit">
    @csrf
    <div class="flex flex-col gap-2 items-center text-center">
        <label>Amount
            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 sm:text-sm">{{ config('global.currency_symbol') }}</span>
                </div>
                <input type="text"
                       class="input center"
                       name="amount"
                       placeholder="xx.xx"
                       value="{{ old('amount') }}"
                       required
                       oninput="copyBuyForm()">
            </div>
        </label>
        <label>Account
            <select id="account_number"
                    name="account_id"
                    class="input">
                @foreach($accounts as $account)
                    <option
                        value="{{ $account->id }}">{{ $account->label }} ({{ $account->number }}
                        ) {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                @endforeach
            </select>
        </label>
    </div>
</form>

<form method="POST" id="withdraw" action="/wallet-withdraw">
    @csrf
    <div class="flex flex-col gap-2 items-center text-center">
        <select
            style="display:none"
            id="account_number"
            name="account_id"
            class="input">
            @foreach($accounts as $account)
                <option
                    value="{{ $account->id }}">{{ $account->label }} ({{ $account->number }}
                    ) {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
            @endforeach
        </select>
        <input
            class="input"
            name="amount"
            placeholder="xx.xx"
            value="{{ old('amount') }}"
            required
            type="hidden">
    </div>
</form>

<div class="mt-4 flex flex-row justify-between w-max center" style="gap: 1.5em">
    <button type="submit"
            form="deposit"
            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800 mr-0">
        Deposit
    </button>
    <button type="submit"
            onclick="copyBuyForm()"
            form="withdraw"
            class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 mr-0">
        Withdraw
    </button>
</div>
