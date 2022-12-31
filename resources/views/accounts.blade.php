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
            <form method="POST" action="/accounts/create">
                @csrf
                <label>
                    <input type="text" name="name" placeholder="Account Name" required>
                    <input type="text" name="currency" placeholder="Currency" required>
                </label>
                <input type="submit">
            </form>
            <div>
                @if(session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        <span class="font-medium">{{ session()->get('message') }}</span>
                    </div>
                @endif
            </div>
            <div class="my-5">
                <table class="center w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Name</th>
                        <th scope="col" class="py-3 px-6">Account</th>
                        <th scope="col" class="py-3 px-6">Balance</th>
                        <th scope="col" class="py-3 px-6">Currency</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="dark:text-white left py-4 px-6">
                                <a href="/accounts/{{ $account->name }}">
                                    {{ $account->name }}
                                </a>
                            </td>
                            <td class="dark:text-white left py-4 px-6">{{ $account->number }}</td>
                            <td class="dark:text-white right py-4 px-6">{{ number_format($account->balance/100, 2) }}</td>
                            <td class="dark:text-white right py-4 px-6">{{ $account->currency }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
