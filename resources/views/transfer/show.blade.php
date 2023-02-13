<x-app-layout>
    <div class="center" style="width: 60%; height: 60%">
        <x-floating-button-calculator/>
        <x-message-or-error/>

        <div class="flex" style="justify-content: center;  align-items: center">
            <div class="card-standard pb-6 w-1/2" style="margin-top: 0 !important">
                <div class="heading">Transfer money</div>
                @if($accounts->isEmpty())
                    <div class="heading-medium"><a href="{{ route('accounts.index') }}" class="text-purple-900 underline">Open an account</a> to start making transactions!</div>
                @else
                    @include('transfer.partials.form')
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
