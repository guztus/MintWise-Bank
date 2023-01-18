<x-app-layout>
    <style>
        input, select {
            width: 500px !important;
            text-align: center;
        }
    </style>

    <div class="center" style="width: 60%; height: 60%">
        <x-message-or-error/>
        <div class="flex" style="justify-content: center;  align-items: center">
            <div class="card-standard pb-6 w-1/2" style="margin-top: 0 !important">
                <div class="heading">Transfer money</div>
                @if($accounts->isEmpty())
                    <div class="heading-medium"><a href="{{ route('accounts.index') }}" class="text-purple-900 underline">Open an account</a> to start making transactions!</div>
                @else
                <form method="POST" action="/transfer">
                    @csrf
                    <div class="flex"
                         style="flex-direction: column; row-gap: 1em; justify-content: center;  align-items: center;">
                        <label>Payer Account
                            <select id="account_number"
                                    name="payerAccountNumber"
                                    class="input">
                                @foreach($accounts as $account)
                                    <option
                                        value="{{ $account->number }}">{{ $account->label }} ({{ $account->number }}
                                        ) {{ number_format($account->balance/100, 2) }} {{ $account->currency }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>Recipients Account Number
                            <input type="text"
                                   class="input"
                                   name="beneficiaryAccountNumber" value="{{ old('beneficiaryAccountNumber') }}"
                                   placeholder="xxxxxxxxxxxxxxxxxxxxx"
                                   required>
                        </label>
                        <label>Amount
                            <input type="text"
                                   class="input"
                                   name="amount" placeholder="xx.xx" value="{{ old('amount') }}" required>
                        </label>
                        <label>Description
                            <input type="text"
                                   class="input"
                                   name="description" placeholder="xxxxx xxx xxxxx" value="{{ old('description') }}"
                                   required>
                        </label>
                        <label>Security Code
                            <input type="password"
                                   class="input"
                                   name="code" placeholder="Code Nr. {{ $codeNumber }}" required>
                        </label>
                        <input type="submit" class="btn mt-4" value="Send">
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
