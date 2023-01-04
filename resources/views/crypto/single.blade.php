<x-app-layout>
    <style>
        .center {
            margin-left: auto;
            margin-right: auto;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

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

    <div class="container-fluid-fluid" style="margin-right: 0">
        <div class="center" style="width: 50%; height: 50%; text-align: center">
            <div>
                <a class="center block max-w-lg mb-4 p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-center my-5">
                        <img src="{{ $crypto->logo }}" alt="icon">
                    </div>
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $crypto->symbol }}</h5>
                    <p class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        $ {{ number_format($crypto->quote->USD->price, 6) }}
                        <span style="
                            font-size: 0.8em;
                            vertical-align: super">
                        {{ number_format($crypto->quote->USD->percent_change_24h, 2) }}</span>
                    </p>
                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Volume (24h)</th>
                            <td class="border px-4 py-2">{{ $crypto->quote->USD->volume_24h }}
                                <span style="
                                    font-size: 0.8em;
                                    vertical-align: super">{{ number_format($crypto->quote->USD->volume_change_24h, 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2">Circulating Supply</th>
                            <td class="border px-4 py-2">{{ $crypto->circulating_supply }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2">Total Supply</th>
                            <td class="border px-4 py-2">{{ $crypto->total_supply }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2">Max Supply</th>
                            <td class="border px-4 py-2">{{ $crypto->max_supply }}</td>
                        </tr>
                        </thead>
                    </table>
                </a>
            </div>
            <div>
                {{--                form for buying or selling crypto --}}
                <div class="flex flex-row" style="align-content: center; justify-content: center">
                    <form action="{{ route('crypto.buy', $crypto->symbol) }}" method="post">
                        @csrf
                        <div>
                            <input name="asset_amount" type="number" placeholder="{{ $crypto->symbol }}" step="0.000000001"
                                   required>
                        </div>
                        <div>
                            <input name="money_amount" type="number" placeholder="Money Amount" step="0.01" min="0.01"
                                   required>
                        </div>
                        <select
                            class="center w-50 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($accounts as $account)
                                <option
                                    value="{{ $account->number }}">{{ $account->name }} {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                            @endforeach
                        </select>
                        <div>
                            <button type="submit"
                                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                Buy
                            </button>
                        </div>
                    </form>
                    <form action="{{ route('crypto.sell', $crypto->symbol) }}" method="post">
                        @csrf
                        <div>
                            <input name="asset_amount" type="number" placeholder="{{ $crypto->symbol }}" required>
                        </div>
                        <div>
                            <input name="money_amount" type="number" placeholder="Money Amount" step="0.01" min="0.01"
                                   required>
                        </div>
                        <div>
                            <button type="submit"
                                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Sell
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
