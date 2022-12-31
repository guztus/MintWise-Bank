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
                <h1 class="text-2xl font-bold">Cards</h1>
            </div>
            <form method="POST" action="/cards/create">
                @csrf
                    <label for="debit">Debit</label>
                <input type="radio" id="debit" name="type" value="debit" checked>
                    <label for="credit">Credit</label>
                <input type="radio" id="credit" name="type" value="credit">
                <input type="text" name="name" placeholder="name" required>
                <input type="submit">
            </form>
            <div>
                @if(session()->has('message'))
                    <div
                        class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        <span class="font-medium">{{ session()->get('message') }}</span>
                    </div>
                @endif
            </div>
            <div class="my-5">
                <table class="center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Type</th>
                        <th scope="col" class="py-3 px-6">Number</th>
                        <th scope="col" class="py-3 px-6">Expiration Date</th>
                        <th scope="col" class="py-3 px-6">Security Code</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cards as $card)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="dark:text-white left py-4 px-6">
                                {{--                                <a href="/card/{{ $account->name }}">--}}
                                {{ $card->type }}
                                {{--                                </a>--}}
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
    </div>
</x-app-layout>
