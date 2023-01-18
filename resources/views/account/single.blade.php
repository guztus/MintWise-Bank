<x-app-layout>
    <script src="https://kit.fontawesome.com/39748767d3.js" crossorigin="anonymous"></script>

    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <x-message-or-error/>
        <div class="card-standard">
            <div>
                <h1 class="text-2xl font-bold">Overview</h1>
            </div>
            <table
                class="table-rounded table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Name</th>
                    <th scope="col" class="py-3 px-6">Number</th>
                    <th scope="col" class="py-3 px-6">Currency</th>
                    <th scope="col" class="py-3 px-6 right">Balance</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="dark:text-white left py-4 px-6">{{ $account->label }}</td>
                    <td class="dark:text-white left py-4 px-6">{{ $account->number }}</td>
                    <td class="dark:text-white center py-4 px-6">{{ $account->currency }}</td>
                    <td class="dark:text-white right py-4 px-6">{{ number_format($account->balance/100, 2) }}</td>
                    <td class="right" style="padding-right: 0.5em">
                        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button">
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownDots"
                             class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                             style="width: max-content">
                            <div
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <!-- Modal toggle -->
                                <button
                                    data-modal-target="renameAccountModal"
                                    data-modal-toggle="renameAccountModal"
                                    class="w-full text-left">
                                    Change Label
                                </button>
                            </div>
                            <div>
                                <div
                                    class="hover:text-white hover:bg-red-700 block px-4 py-2 hover:bg-gray-100">
                                    <!-- Modal toggle -->
                                    <button
                                        data-modal-target="deleteAccountModal"
                                        data-modal-toggle="deleteAccountModal"
                                        class="w-full text-left">
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="left">
            <div id="accordion-flush" data-accordion="collapse"
                 data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                 data-inactive-classes="text-gray-500 dark:text-gray-400">
                <!-- Main modal -->
                <div id="renameAccountModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                    <div class="relative w-full h-full max-w-2xl md:h-auto">
                        <!-- Modal content -->
                        <div class="py-1 relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Account Label Change
                                </h3>
                                <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="renameAccountModal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="flex my-6" style="justify-content: center">
                                <form method="POST"
                                      id="label_change"
                                      class="mx-2"
                                      action="{{ route('account.update', $account->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input
                                        class="mx-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        name="newLabel" value="{{ $account->label }}">
                                </form>
                                <button
                                    form="label_change" type="submit"
                                    class="mx-2 py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                    data-modal-hide="deleteAccountModal">
                                    Rename
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main modal -->
                <div id="deleteAccountModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                    <div class="relative w-full h-full max-w-2xl md:h-auto">
                        <!-- Modal content -->
                        <div class="py-1 relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Account Deletion Confirmation
                                </h3>
                                <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="deleteAccountModal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="center my-6">
                                {{--            Reassurance that user wants to delete--}}
                                <h3>Are you sure you want to delete account Nr.({{ $account->number }}) ?</h3>
                            </div>
                            <!-- Modal footer -->
                            <form
                                id="deleteAccount"
                                method="POST"
                                action="{{ route('account.destroy', $account->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <div
                                class="flex items-center p-3 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600"
                                style="justify-content: space-evenly">
                                <button
                                    type="submit"
                                    form="deleteAccount"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                    Yes, delete this account
                                </button>
                                <button
                                    class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                    data-modal-hide="deleteAccountModal">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

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

                                {{--                        @if(empty(request()))--}}
                                <button type="button"
                                        class="btn"
                                        onclick="window.location.href = '{{ request()->url() }}'">
                                    Clear
                                </button>
                                {{--                        @endif--}}
                            </div>
                        </div>
                        <table
                            class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400 pb-0">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">@sortablelink('created_at', 'Date')</th>
                                <th scope="col" class="py-3 px-6">Beneficiary/Payer</th>
                                <th scope="col" class="py-3 px-6">Description</th>
                                <th scope="col" class="py-3 px-6 right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $endingBalance = $account->balance;
                                $debitTurnover = 0;
                                $creditTurnover = 0;
                            @endphp
                            @foreach($transactions as $transaction)
                                @php
                                    if ($transaction->beneficiary_account_number == $account->number) {
                                        $debitTurnover += $transaction->amount_beneficiary;
                                        $endingBalance += $transaction->amount_beneficiary;
                                    } else {
                                        $creditTurnover += $transaction->amount_payer;
                                        $endingBalance -= $transaction->amount_payer;
                                    }
                                @endphp
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="dark:text-white left py-4 px-6">{{ date('d/m/y H:i', strtotime($transaction->created_at)) }}</td>
                                    <td class="dark:text-white left py-4 px-6">{{ $transaction->beneficiary_account_number }}</td>
                                    <td class="dark:text-white left py-4 px-6">{{ $transaction->description }}</td>
                                    @if($transaction->beneficiary_account_number == $account->number)
                                        <td class="text-green-700 right py-4 px-6">
                                            +{{ number_format($transaction->amount_beneficiary, 2) }}</td>
                                    @else
                                        <td class="text-red-700 right py-4 px-6">
                                            -{{ number_format($transaction->amount_payer, 2) }}</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="my-4 px-4">
                            {{ $transactions->links() }}
                        </div>
                        <table class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr style="font-weight: bold">
                                <td colspan="4" class="dark:text-white left py-4 px-6">Ending Balance</td>
                                <td class="dark:text-white right py-4 px-6">{{ number_format($endingBalance/100, 2) }}</td>
                            </tr>
                            <tr class="text-red-700">
                                <td colspan="4" class="text-red-700 left py-4 px-6">Credit Turnover</td>
                                <td class="text-red-700 right py-4 px-6">{{ number_format($creditTurnover/100*(-1), 2) }}</td>
                            </tr>
                            <tr class="text-green-700">
                                <td colspan="4" class="dark:text-white left py-4 px-6">Debit Turnover</td>
                                <td class="text-green-700 right py-4 px-6">{{ number_format($debitTurnover/100, 2) }}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
