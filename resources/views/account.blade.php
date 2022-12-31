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
    </style>

    <div class="container-fluid" style="margin-right: 0">
        <div class="center" style="width: 50%; height: 50%; text-align: center">
            <div>
                <h1 class="text-2xl font-bold">Overview</h1>
                <p class="dark:text-white">Account</p>
            </div>
            <div class="my-5">
                <table class="center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Name</th>
                        <th scope="col" class="py-3 px-6">Account</th>
                        <th scope="col" class="py-3 px-6">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="dark:text-white left py-4 px-6">{{ $account->name }}</td>
                        <td class="dark:text-white left py-4 px-6">{{ $account->number }}</td>
                        <td class="dark:text-white right py-4 px-6">{{ number_format($account->balance/100, 2) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <p class="dark:text-white">Transactions</p>
                <div class="my-5">
                    <table class="center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">Receiver</th>
                            <th scope="col" class="py-3 px-6">Type</th>
                            <th scope="col" class="py-3 px-6">Description</th>
                            <th scope="col" class="py-3 px-6">Currency</th>
                            <th scope="col" class="py-3 px-6">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $endingBalance = 0;
                            $debitTurnover = 0;
                            $creditTurnover = 0;
                        @endphp
                        @foreach($transactions as $transaction)
                            @php
                                $endingBalance += $transaction->amount;
                                if ($transaction->amount > 0) {
                                    $debitTurnover += $transaction->amount;
                                } else {
                                    $creditTurnover += $transaction->amount;
                                }
                            @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="dark:text-white left py-4 px-6">{{ $transaction->recipient_account_number }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ $transaction->type }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ $transaction->description }}</td>
                                <td class="dark:text-white right py-4 px-6">{{ $transaction->currency }}</td>
                                <td class="dark:text-white right py-4 px-6">{{ number_format($transaction->amount/100, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr style="font-weight: bold">
                            <td colspan="4" class="dark:text-white left py-4 px-6">Total</td>
                            <td class="dark:text-white right py-4 px-6">{{ number_format($endingBalance/100, 2) }}</td>
                        </tr>
                        <tr style="color: darkred">
                            <td colspan="4" class="dark:text-white left py-4 px-6">Credit Turnover</td>
                            <td class="dark:text-white right py-4 px-6">{{ number_format($creditTurnover/100*(-1), 2) }}</td>
                        </tr>
                        <tr style="color: darkgreen">
                            <td colspan="4" class="dark:text-white left py-4 px-6">Debit Turnover</td>
                            <td class="dark:text-white right py-4 px-6">{{ number_format($debitTurnover/100, 2) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
