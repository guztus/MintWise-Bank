<div class="card-standard">
    <div class="heading">Accounts</div>
    <div class="flex" style="flex-direction: column; gap: 2em">
        <table
            class="table-rounded table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6 left">Name</th>
                <th scope="col" class="py-3 px-6 left">Account Nr.</th>
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
                    <td class="dark:text-white right py-4 px-6">{{ number_format($account->balance/100, 2) }}</td>
                    <td class="dark:text-white center py-4 px-6">{{ $account->currency }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="my-4 px-4">
            {{ $accounts->links() }}
        </div>
    </div>
</div>
