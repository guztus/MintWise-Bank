<x-app-layout>
    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <x-message-or-error/>
        <div class="card-standard">
            <div class="heading">Accounts</div>
            <div class="flex" style="flex-direction: column; gap: 2em">
                <div>
                    @if(!$accounts->isEmpty())
                        <table
                            class="table-rounded table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6 left">Name</th>
                                <th scope="col" class="py-3 px-6 left">Account Nr.</th>
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
            </div>
        </div>
        <div
            class="card-standard pb-6">
            <div class="heading-medium">Open a new account</div>
            <form method="post" action="{{ route('account.create') }}">
                @csrf
                <div class="flex" style="justify-content: center;  align-items: center; column-gap: 0.5em;">
                    <div class="flex" style="flex-direction: row">
                        <input type="text"
                               name="label"
                               class="w-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-purple-800 focus:border-purple-800 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-800 dark:focus:border-purple-800"
                               placeholder="Account label" required>
                        <select id="countries"
                                class="w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-purple-800 focus:border-purple-800 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-800 dark:focus:border-purple-800"
                                name="currency">
                            @foreach($currencies as $currency => $rate)
                                <option value="{{ $currency }}">{{ $currency }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="submit" class="btn" value="Open a new Account">
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
