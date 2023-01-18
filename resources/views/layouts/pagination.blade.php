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
