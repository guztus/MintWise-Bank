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
                        <th scope="col" class="py-3 px-6">Number</th>
                        <th scope="col" class="py-3 px-6 right">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="dark:text-white left py-4 px-6">{{ $account->label }}</td>
                        <td class="dark:text-white left py-4 px-6">{{ $account->number }}</td>
                        <td class="dark:text-white right py-4 px-6">{{ number_format($account->balance/100, 2) }}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="left">

                <div id="accordion-flush" data-accordion="collapse"
                     data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                     data-inactive-classes="text-gray-500 dark:text-gray-400">
                    <h2 id="accordion-flush-heading-2">
                        <button type="button"
                                class="flex items-center justify-between w-full py-3 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                                data-accordion-target="#accordion-flush-body-2" aria-expanded="false"
                                aria-controls="accordion-flush-body-2">
                            <span class="center">Cards ({{ count($cards) }})</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>

                    <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                        <div class="py-5 font-light border-b border-gray-200 dark:border-gray-700">
                            <table class="center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Type</th>
                                    <th scope="col" class="py-3 px-6">Number</th>
                                    <th scope="col" class="py-3 px-6 right">Expiration Date</th>
                                    <th scope="col" class="py-3 px-6 right">Security Code</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cards as $card)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="dark:text-white left py-4 px-6">
                                            {{ $card->type }}
                                        </td>
                                        <td class="dark:text-white left py-4 px-6">{{ $card->number }}</td>
                                        <td class="dark:text-white right py-4 px-6">{{ date('m/y', strtotime($card->expiration_date)) }}</td>
                                        <td class="dark:text-white right py-4 px-6">{{ $card->security_code }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="dark:text-white left py-4 px-6">
                                        <a href="/cards/create" class="hover:text-gray-900 hover:">
                                            Order a new Card
                                        </a>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <p class="dark:text-white">Transactions</p>
                <div class="my-5">
                    <table class="center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">#</th>
                            <th scope="col" class="py-3 px-6">Date</th>
                            <th scope="col" class="py-3 px-6">Beneficiary/Payer</th>
                            <th scope="col" class="py-3 px-6">Description</th>
                            <th scope="col" class="py-3 px-6 right">Currency</th>
                            <th scope="col" class="py-3 px-6 right">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $rowCount = 1;
                            $endingBalance = 0;
                            $debitTurnover = 0;
                            $creditTurnover = 0;
                        @endphp
                        @foreach($transactions as $transaction)
                            @php
                                $endingBalance += $transaction->amount;
                                if ($transaction->beneficiary_account_number == $account->number) {
                                    $debitTurnover += $transaction->amount;
                                } else {
                                    $creditTurnover += $transaction->amount;
                                }
                            @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="dark:text-white left py-4 px-6">{{ $rowCount++ }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ date('d/m/y', strtotime($transaction->created_at)) }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ $transaction->beneficiary_account_number }}</td>
                                <td class="dark:text-white left py-4 px-6">{{ $transaction->description }}</td>
                                <td class="dark:text-white right py-4 px-6">{{ $transaction->currency }}</td>
                                @if($transaction->beneficiary_account_number == $account->number)
                                    <td class="text-green-700 right py-4 px-6">
                                        +{{ number_format($transaction->amount/100, 2) }}</td>
                                @else
                                    <td class="text-red-700 right py-4 px-6">
                                        -{{ number_format($transaction->amount/100, 2) }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr style="font-weight: bold">
                            <td colspan="5" class="dark:text-white left py-4 px-6">Total</td>
                            <td class="dark:text-white right py-4 px-6">{{ number_format($endingBalance/100, 2) }}</td>
                        </tr>
                        <tr class="text-red-700">
                            <td colspan="5" class="text-red-700 left py-4 px-6">Credit Turnover</td>
                            <td class="text-red-700 right py-4 px-6">{{ number_format($creditTurnover/100*(-1), 2) }}</td>
                        </tr>
                        <tr class="text-green-700">
                            <td colspan="5" class="dark:text-white left py-4 px-6">Debit Turnover</td>
                            <td class="text-green-700 right py-4 px-6">{{ number_format($debitTurnover/100, 2) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
