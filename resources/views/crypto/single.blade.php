<x-app-layout>
    <style>
        /* Style inputs */
        input[type=number], select {
            width: 95%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let percentChanges = document.getElementsByClassName("percent-change");

            for (let i = 0; i < percentChanges.length; i++) {
                let percentChange = percentChanges[i];
                let percentValue = percentChange.getAttribute("data-percent-change");
                percentChange.textContent = Math.abs(parseFloat(percentValue)).toLocaleString('en-US', {
                    maximumFractionDigits: 2,
                    useGrouping: true
                }) + "%";
                if (percentValue < 0) {
                    percentChange.textContent = "↓ - " + percentChange.textContent;
                    percentChange.style.color = "red";
                } else {
                    // place the arrow in front of the number
                    percentChange.textContent = "↑ + " + percentChange.textContent;
                    percentChange.style.color = "green";
                }
            }
        });

        function setAccount() {
            //     test if this function is called
            alert("setAccount() called");
            let account = document.getElementById("account").value;
            let url = "/crypto/" + account;
            window.location.href
        }
    </script>

    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <x-message-or-error/>
        <div>
            <div class="center card-standard w-1/2">
                <div class="flex text-xs text-gray-500" style="justify-content: flex-end">Refreshed: {{ \Carbon\Carbon::parse(strtotime($crypto->getTimestamp()))->addHours(2)->format('M d-H:i:s') }}</div>
                <div class="flex items-center justify-center my-5">
                    <img src="{{ $crypto->getLogo() }}" alt="icon">
                </div>
                <div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $crypto->getSymbol() }}</div>
                <div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    € {{ number_format($crypto->getPrice(), 6) }}
                    <span style="
                            font-size: 0.7em;
                            vertical-align: super" class="py-2 percent-change text-xs"
                          data-percent-change="{{ $crypto->getPercentChange24h() }}"></span>
                </div>
                <div>
                    <table class="table-rounded table-auto">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Volume (24h)</th>
                            <td class="border px-4 py-2">{{ $crypto->getVolume24h() }}
                                <span class="px-4 py-2 percent-change text-xs" data-percent-change="{{ $crypto->getVolumeChange24h() }}"></span>
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2">Circulating Supply</th>
                            <td class="border px-4 py-2">{{ $crypto->getCirculatingSupply() }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2">Total Supply</th>
                            <td class="border px-4 py-2">{{ $crypto->getTotalSupply() }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2">Max Supply</th>
                            <td class="border px-4 py-2">{{ $crypto->getMaxSupply() }}</td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div>
                    {{--                display asset owned amount for this asset--}}
                    @if ($assetOwned)
                        <div class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                            You own {{ $assetOwned->amount }} {{ $crypto->getSymbol() }}
                        </div>
                        <div class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                            Average price: € {{ number_format($assetOwned->average_cost, 2) }}
                        </div>
                        <div class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                            Total worth: € {{ number_format($assetOwned->amount * $crypto->getPrice(), 2) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div>
            {{--                form for buying or selling crypto --}}
            <div class="container-fluid">
                <div class="card-standard flex flex-col w-1/2 center">
                    @if($accounts->isEmpty())
                        <div class="heading-medium"><a href="{{ route('accounts.index') }}" class="text-purple-900 underline">Open an account</a> to start trading!</div>
                    @else
                    <div class="flex flex-row">
                        <form id="buy" action="{{ route('crypto.buy', $crypto->getSymbol()) }}" method="post">
                            @csrf
                            <input name="symbol" value="{{ $crypto->getSymbol() }}" hidden>
                            <input id="asset_amount" name="assetAmount" type="number"
                                   placeholder="{{ $crypto->getSymbol() }}"
                                   step="0.000000001"
                                   required
                                {{--                                       oninput="fiatChangeLive()"--}}
                            >
                            <input id="fiat_amount" type="number" placeholder="Money Amount" step="0.01"
                                   min="0.01"
                                {{--                                       oninput="assetChangeLive()"--}}
                            >
                            <select
                                form="buy"
                                class="center w-50 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="payerAccountNumber">
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
                            <input name="assetAmount" type="number" placeholder="{{ $crypto->getSymbol() }}"
                                   step="0.000000001"
                                   required>
                            <input type="number" placeholder="Money Amount" step="0.01"
                                   min="0.01">
                            <select
                                form="sell"
                                class="center w-50 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="payerAccountNumber"
                            >
                                @foreach($accounts as $account)
                                    <option
                                        value="{{ $account->number }}">{{ $account->label }} ({{ $account->number }}
                                        ) {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="flex flex-row center w-max" style="justify-content: space-evenly">
                        <div style="padding-right: 4em">
                            <button type="submit"
                                    form="buy"
                                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                Buy
                            </button>
                        </div>
                        <div style="padding-left: 4em">
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
        </div>
        <div class="card-standard">
            <div class="heading">Transactions</div>
            @if ($transactions->isEmpty())
                <div class="heading-medium">Your {{ $crypto->getSymbol() }} transactions will show up here!</div>
            @else
                <div class="my-5">
                    <table class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">#</th>
                            <th scope="col" class="py-3 px-6">Date</th>
                            <th scope="col" class="py-3 px-6">Beneficiary/Payer</th>
                            <th scope="col" class="py-3 px-6">Description</th>
                            <th scope="col" class="py-3 px-6 right">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $rowCount = 1;
                            $endingBalance = 0;
                            $debitTurnover = 0;
                            $creditTurnover = 0;
//                        @endphp
                        @foreach($transactions as $transaction)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="dark:text-white left py-4 px-6">{{ $rowCount++ }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ date('d/m/y', strtotime($transaction->created_at)) }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ $transaction->beneficiary_account_number }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ $transaction->description }}</td>
                                @if($transaction->beneficiary_account_number != 'Crypto')
                                    <td class="text-green-700 right py-4 px-6">
                                        +{{ number_format($transaction->amount_beneficiary, 2) }}</td>
                                @else
                                    <td class="text-red-700 right py-4 px-6">
                                        -{{ number_format($transaction->amount_payer, 2) }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        {{--                        <tfoot>--}}
                        {{--                        <tr style="font-weight: bold">--}}
                        {{--                            <td colspan="4" class="dark:text-white left py-4 px-6">Total</td>--}}
                        {{--                            <td class="dark:text-white right py-4 px-6">{{ number_format($endingBalance/100, 2) }}</td>--}}
                        {{--                        </tr>--}}
                        {{--                        <tr class="text-red-700">--}}
                        {{--                            <td colspan="4" class="text-red-700 left py-4 px-6">Credit Turnover</td>--}}
                        {{--                            <td class="text-red-700 right py-4 px-6">{{ number_format($creditTurnover/100*(-1), 2) }}</td>--}}
                        {{--                        </tr>--}}
                        {{--                        <tr class="text-green-700">--}}
                        {{--                            <td colspan="4" class="dark:text-white left py-4 px-6">Debit Turnover</td>--}}
                        {{--                            <td class="text-green-700 right py-4 px-6">{{ number_format($debitTurnover/100, 2) }}</td>--}}
                        {{--                        </tr>--}}
                        {{--                        </tfoot>--}}
                    </table>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>
