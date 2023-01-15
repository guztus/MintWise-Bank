<x-app-layout>
    <script>
        function correctId() {

        }
    </script>
    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <div>
            <h1 class="text-2xl font-bold">Accounts</h1>
        </div>
        <x-message-or-error/>
        <div class="my-5">
            <div>
                @if(!$accounts->isEmpty())
                    <table
                        class="table-rounded table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md rounded">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6 left">Name</th>
                            <th scope="col" class="py-3 px-6 left">Account</th>
                            <th scope="col" class="py-3 px-6 right">Credit Limit</th>
                            <th scope="col" class="py-3 px-6 right">Balance</th>
                            <th scope="col" class="py-3 px-6 center">Currency</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="dark:text-white left py-4 px-6">
                                    <a href="/accounts/{{ $account->id }}" class="hover:text-gray-900 hover:">
                                        {{ $account->label }}
                                    </a>
                                </td>
                                <td class="dark:text-white left py-4 px-6">{{ $account->number }}</td>
                                <td class="dark:text-white right py-4 px-6">{{ number_format($account->credit_limit/100, 2) }}</td>
                                <td class="dark:text-white right py-4 px-6">{{ number_format($account->balance/100, 2) }}</td>
                                <td class="dark:text-white center py-4 px-6">{{ $account->currency }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div
                class="my-6 p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                <h3>Open a new account</h3>
                <form method="post" action="{{ route('account.create') }}">
                    @csrf
                    <div class="flex px-32" style="justify-content: space-evenly">
                        <input type="text"
                               name="label"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Account label" required>
                        <select id="countries"
                                class="w-1/6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="currency">
                            @foreach($currencies as $currency => $rate)
                                <option value="{{ $currency }}">{{ $currency }}</option>
                            @endforeach
                        </select>
                        <input type="submit" value="Open a new Account">
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
