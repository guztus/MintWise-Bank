<x-app-layout>
    <script src="https://kit.fontawesome.com/39748767d3.js" crossorigin="anonymous"></script>
    <style>
        .dangerHover:hover {
            background: rgba(255, 0, 0, 0.54);
            color: black;
        }
    </style>

    <div class="container-fluid" style="margin-right: 0">
        <div class="center" style="width: 50%; height: 50%; text-align: center">
            <div>
                <h1 class="text-2xl font-bold">Overview</h1>
                <p class="dark:text-white">Account</p>
            </div>
            <div class="my-5">
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
                        <td class="dark:text-white left py-4 px-6">{{ $account->currency }}</td>
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
                            <table
                                class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                                        <a href="/cards" class="hover:text-gray-900 hover:">
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

            <div>
                <p class="dark:text-white">Transactions</p>
                <div class="my-5">
                    <div class="flex" style="flex-direction: row; justify-content: center">
                        <form>
                            <input type="text" name="search"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Search in transactions"
                                   value="{{ Request::input('search') }}">
                        </form>
                        <button
                            class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Search
                        </button>
                        <a type="button"
                           class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                           href="{{ request()->url() }}">Reset filters</a>
                    </div>
                    <table class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">#</th>
                            <th scope="col" class="py-3 px-6">@sortablelink('created_at', 'Date')</th>
                            <th scope="col" class="py-3 px-6">Beneficiary/Payer</th>
                            <th scope="col" class="py-3 px-6">Description</th>
                            <th scope="col" class="py-3 px-6 right">@sortablelink('amount_beneficiary', 'Amount')</th>
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
                        <tfoot>
                        <tr style="font-weight: bold">
                            <td colspan="4" class="dark:text-white left py-4 px-6">Total</td>
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
                        </tfoot>
                    </table>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
