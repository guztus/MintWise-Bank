<x-app-layout>
    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <div>
            <h1 class="text-2xl font-bold">Cards</h1>
        </div>
        <form method="POST" action="{{ route('cards.create') }}">
            @csrf
            {{--                <label for="debit">Debit</label>--}}
            <input type="radio" id="debit" name="type" value="debit" checked hidden>
            {{--                <label for="credit">Credit</label>--}}
            {{--                <input type="radio" id="credit" name="type" value="credit">--}}
            {{--                selector that has foreach going through cards--}}
            <select name="account_id" id="account_id" required>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->label }} {{ $account->number }}</option>
                @endforeach

                <input type="submit" value="Order">
            </select>
        </form>

        <x-message-or-error/>

        <div class="my-5">
            <table class="table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
            </table>
        </div>
    </div>
</x-app-layout>
