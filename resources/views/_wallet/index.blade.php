<x-app-layout>
    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <x-message-or-error/>
        <div class="card-standard">
            <div class="heading">Wallets</div>
            <div class="flex" style="flex-direction: column; gap: 2em">
                <table
                    class="table-rounded table-rounded center w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6 left">Name</th>
                        <th scope="col" class="py-3 px-6 left">Wallet Nr.</th>
                        <th scope="col" class="py-3 px-6 right">FIAT balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wallets as $wallet)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="dark:text-white left py-4 px-6">
                                <a href="/accounts/{{ $wallet->id }}" class="hover:text-gray-900 hover:">
                                    {{ $wallet->label }}
                                </a>
                            </td>
                            <td class="dark:text-white left py-4 px-6">{{ $wallet->number }}</td>
                            <td class="dark:text-white right py-4 px-6">
                                € {{ number_format($wallet->balance/100, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('_wallet.partials.create-wallet')
    </div>
</x-app-layout>
