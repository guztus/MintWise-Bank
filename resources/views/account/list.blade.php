<x-app-layout>
    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <x-message-or-error/>
        @if(!$accounts->isEmpty())
            @include('account.partials.account-overview')
        @endif

        <div class="flex" style="justify-content: center;  align-items: center">
            <div class="card-standard pb-6 w-1/2">
                @if($accounts->isEmpty())
                    <div class="heading">Accounts</div>
                    <div class="heading">You do not have any open accounts!</div>
                @endif
                @include('account.partials.create-account')
            </div>
        </div>
    </div>
</x-app-layout>
