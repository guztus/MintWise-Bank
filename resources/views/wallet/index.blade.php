<x-app-layout>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let percentChanges = document.getElementsByClassName("percent-change");

            for (let i = 0; i < percentChanges.length; i++) {
                let percentChange = percentChanges[i];
                let percentValue = percentChange.getAttribute("data-percent-change");
                percentChange.textContent = Math.abs(parseFloat(percentValue)).toLocaleString('en-US', {
                    maximumFractionDigits: 2,
                    useGrouping: true
                }) + " %";
                if (percentValue < 0) {
                    percentChange.textContent = "↓ - " + percentChange.textContent;
                    percentChange.style.color = "red";
                } else {
                    percentChange.textContent = "↑ + " + percentChange.textContent;
                    percentChange.style.color = "green";
                }
            }

            let cashChanges = document.getElementsByClassName("cash-change");

            for (let i = 0; i < cashChanges.length; i++) {
                let cashChange = cashChanges[i];
                let cashValue = cashChange.getAttribute("data-cash-change");
                cashChange.textContent = "€ " + Math.abs(parseFloat(cashValue)).toLocaleString('en-US', {
                    maximumFractionDigits: 2,
                    useGrouping: true
                });
                if (cashValue < 0) {
                    cashChange.textContent = "↓ - " + cashChange.textContent;
                    cashChange.style.color = "red";
                } else {
                    cashChange.textContent = "↑ + " + cashChange.textContent;
                    cashChange.style.color = "green";
                }
            }
        });
    </script>

    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <x-message-or-error/>

        @if($wallet->balance <= 0)
            <div class="flex" style="justify-content: center;  align-items: center">
                <div class="card-standard pb-6 w-1/2">
                    <p class="heading">Your Asset wallet FIAT balance is {{ number_format($wallet->balance, 2) }}!</p>
                    <p class="my-6">Add money to your wallet from your bank accounts</p>
                    @if(count($accounts) < 1)
                        <p>You do not have any accounts! <a href="/accounts" class="text-purple-900 font-bold transition duration-150 ease-in-out">Open a new account</a></p>
                    @else
                        @include('wallet.partials.deposit-withdraw-form')
                    @endif
                </div>
            </div>
        @elseif($assets->isEmpty())
        <div class="flex" style="flex-direction: column; justify-content: center;  align-items: center">
            <div
                class="card-standard pb-6 w-1/2">
                <p class="heading">Your Asset wallet FIAT balance is € {{ number_format($wallet->balance / 100, 2) }}!</p>
            </div>
            <div
                class="card-standard pb-6 w-1/2">
                <div class="heading">There are no assets to list!</div>
                <div class="heading-medium">You can browse the crypto market and when you make a purchase, your assets will be visible here! <a href="{{ route('crypto.index') }}" class="text-purple-900 underline">Go to the Cryptocurrency Market</a></div>
            </div>
        </div>
        <div class="flex" style="flex-direction: column; justify-content: center;  align-items: center">
            <div
                class="card-standard pb-6 w-1/2">
                @include('wallet.partials.deposit-withdraw-form')
            </div>
        </div>
        @else
        <div class="card-standard">
            <div class="mb-6">
                <div class="heading">Asset wallet</div>
                    <p>FIAT balance: € {{ number_format($wallet->balance / 100, 2) }}</p>
                    <p>Assets Held: {{ count($assets) }}</p>
                    <p>Total Asset Value: {{ "€ " . number_format(($assets->map(function ($asset) {
                        return $asset->current_price * $asset->amount;
                    }))->sum(), 2) }}</p>
                    <p>Total % Profit/Loss: <span class="py-2 percent-change"
                                                  data-percent-change="{{ (((($assets->map(function ($asset) {
                        return ($asset->current_price * $asset->amount);
                    }))->sum() - ($assets->map(function ($asset) {
                        return ($asset->amount * $asset->average_cost);
                    }))->sum()) ) / ($assets->map(function ($asset) {
                        return ($asset->amount * $asset->average_cost);
                    }))->sum()) * 100 }}"></span></p>

                    <p>Total € Profit/Loss: <span class="py-2 cash-change"
                                                  data-cash-change="{{ ($assets->map(function ($asset) {
                        return ($asset->current_price - $asset->average_cost) * $asset->amount;
                    }))->sum() }}"></span></p>
            </div>
            <div>
                <table
                    class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-2">Symbol</th>
                        <th class="px-4 py-2">Current Price</th>
                        <th class="px-4 py-2">Average Cost</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">€ Amount</th>
                        <th class="px-4 py-2">% Profit/Loss</th>
                        <th class="px-4 py-2">€ Profit/Loss</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assets as $asset)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-2">
                                <a href="/crypto/{{ $asset->symbol }}">{{ $asset->symbol }}</a>
                            </td>
                            <td class="px-4 py-2">{{ number_format($asset->current_price, 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($asset->average_cost, 2) }}</td>
                            <td class="px-4 py-2" id="assetAmount">{{ (float)$asset->amount }}</td>
                            <td class="px-4 py-2">€ {{ number_format($asset->amount * $asset->current_price, 2) }}</td>
                            <td class="px-4 py-2 percent-change"
                                data-percent-change="{{ (($asset->current_price - $asset->average_cost) / $asset->average_cost) * 100 }}">
                            </td>
                            <td class="px-4 py-2 cash-change"
                                data-cash-change="{{ ($asset->current_price - $asset->average_cost) * $asset->amount }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            <div class="flex card-standard pb-6" style="flex-direction: column; justify-content: center;  align-items: center">
                    @include('wallet.partials.deposit-withdraw-form')
            </div>
            <div class="mb-6">
                @include('layouts.transactions', ['identifier' => 'Crypto'])
            </div>
        @endif
    </div>
</x-app-layout>
