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
                <h1 class="text-2xl font-bold">Accounts</h1>
            </div>
            <div>
                @if(session()->has('message'))
                    <div
                        class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        <span class="font-medium">{{ session()->get('message') }}</span>
                    </div>
                @endif
            </div>

            <form method="post" action="{{ route('account.create') }}">
                @csrf
                <label>
                    <input type="text" name="label" placeholder="Account Name" value="New Account" required>
                    <label for="underline_select" class="sr-only">Underline select</label>
                    <select id="underline_select"
                            name="currency"
                            class="center  py-2.5 px-0 w-10 text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                            style="width: 10%">
                        <option value="US-DOLLAR">US Dollar</option>
                        <option value="EUR" selected>EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="YEN">Yen</option>
                        <option value="ZLOTY">Zloty</option>
                    </select>
                </label>
                <input type="submit" value="Create">
            </form>
            <div class="my-5">
                <table class="center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Name</th>
                        <th scope="col" class="py-3 px-6">Account</th>
                        <th scope="col" class="py-3 px-6 right">Credit Limit</th>
                        <th scope="col" class="py-3 px-6 right">Balance</th>
                        <th scope="col" class="py-3 px-6 right">Currency</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="dark:text-white left py-4 px-6">
                                <a href="/accounts/{{ $account->label }}" class="hover:text-gray-900 hover:">
                                    {{ $account->label }}
                                </a>
                            </td>
                            <td class="dark:text-white left py-4 px-6">{{ $account->number }}</td>
                            <td class="dark:text-white right py-4 px-6">{{ number_format($account->credit_limit/100, 2) }}</td>
                            <td class="dark:text-white right py-4 px-6">{{ number_format($account->balance/100, 2) }}</td>
                            <td class="dark:text-white right py-4 px-6">{{ $account->currency }}</td>
                            <td class="dark:text-white right px-2">
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
                                     class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">

                                    <div
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <!-- Modal toggle -->
                                        <button data-modal-target="staticModal" data-modal-toggle="staticModal"
                                                type="button">
                                            Change Label
                                        </button>
                                    </div>
                                    <div>
                                        <div
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <form method="POST" action="{{ route('account.destroy', $account->label) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit"
                                                       value="Close Account">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Main modal -->
                                <div id="staticModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                                     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                    <div class="relative w-full h-full max-w-2xl md:h-auto">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Account Label Change
                                                </h3>
                                                <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="staticModal">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                              clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="center my-4">
                                                <form method="POST"
                                                      id="label_change"
                                                      action="{{ route('account.update', $account->label) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input name="newLabel" value="{{ $account->label }}">
                                                </form>
                                            </div>
                                            <!-- Modal footer -->
                                            <div
                                                class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                <div>
                                                    <div
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        <input form="label_change" type="submit"
                                                               value="Rename">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
