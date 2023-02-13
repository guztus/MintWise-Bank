<div class="card-standard center">
    <div class="heading">Transactions</div>
    <div class="mt-5">
        <div class="flex" style="align-content: center; justify-content: space-evenly">
            <form id="searchquery">
                <input type="text" name="search"
                       class="input"
                       placeholder="Search in transactions"
                       value="{{ Request::input('search') }}">
            </form>

            <div date-rangepicker datepicker-format="yyyy-mm-dd" class="flex items-center">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input form="searchquery" name="from" type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Select date start"
                           value="@if(request('from')){{ request('from') }}@endif">
                </div>
                <span class="mx-2 text-gray-500">to</span>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input form="searchquery" name="to" type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Select date end"
                           value="@if(request('to')){{ request('to') }}@endif">
                </div>
            </div>

            <div>
                <button form="searchquery" type="submit"
                        class="btn">
                    Search
                </button>

                <button type="button"
                        class="btn"
                        onclick="window.location.href = '{{ request()->url() }}'">
                    Clear
                </button>
            </div>
        </div>

        <table
            class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400 pb-0">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-4">@sortablelink('created_at', 'Date')</th>
                <th scope="col" class="py-3 px-4">Beneficiary/Payer</th>
                <th scope="col" class="py-3 px-4">Description</th>
                <th scope="col" class="py-3 px-4 right">Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="dark:text-white left py-4 px-2 pl-4">{{ date('d/m/y H:i', strtotime($transaction->created_at)) }}</td>
                    <td class="dark:text-white left py-4 px-2">{{ $transaction->beneficiary_account_number }}</td>
                    <td class="dark:text-white left py-4 px-2">{{ $transaction->description }}</td>
                    @if($identifier == "Crypto")
                        @if($transaction->beneficiary_account_number == $identifier)
                            <td class="text-red-700 right py-4 px-2 pr-4">
                                - {{ number_format($transaction->amount_payer, 2) }}</td>
                        @else
                            <td class="text-green-700 right py-4 px-2 pr-4">
                                + {{ number_format($transaction->amount_beneficiary, 2) }}</td>
                        @endif
                    @else
                        @if($transaction->beneficiary_account_number == $identifier)
                            <td class="text-green-700 right py-4 px-2 pr-4">
                                + {{ number_format($transaction->amount_beneficiary, 2) }}</td>
                        @else
                            <td class="text-red-700 right py-4 px-2 pr-4">
                                - {{ number_format($transaction->amount_payer, 2) }}</td>
                        @endif
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        @if ($transactions->isEmpty())
            <div class="heading-medium">Your transactions will show up here!</div>
        @endif
        <div class="my-4 px-4">
            {{ $transactions->links() }}
        </div>
        <table class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="text-red-700">
                <td colspan="4" class="text-red-700 left py-4 px-6">Credit Turnover</td>
                <td class="text-red-700 right py-4 px-6">- {{ number_format($credit, 2) }}</td>
            </tr>
            <tr class="text-green-700">
                <td colspan="4" class="dark:text-white left py-4 px-6">Debit Turnover</td>
                <td class="text-green-700 right py-4 px-6">+ {{ number_format($debit, 2) }}</td>
            </tr>
            </thead>
        </table>
    </div>
</div>
