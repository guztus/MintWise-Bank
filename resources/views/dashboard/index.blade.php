<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900">
                    <a style="font-size: 1.2em">Your validation codes:</a>
                    <ol class="list-decimal" style="margin-left: 1em">
                        <li>{{ $codeCard->code_1 }}</li>
                        <li>{{ $codeCard->code_2 }}</li>
                        <li>{{ $codeCard->code_3 }}</li>
                        <li>{{ $codeCard->code_4 }}</li>
                        <li>{{ $codeCard->code_5 }}</li>
                        <li>{{ $codeCard->code_6 }}</li>
                        <li>{{ $codeCard->code_7 }}</li>
                        <li>{{ $codeCard->code_8 }}</li>
                        <li>{{ $codeCard->code_9 }}</li>
                        <li>{{ $codeCard->code_10 }}</li>
                        <li>{{ $codeCard->code_11 }}</li>
                        <li>{{ $codeCard->code_12 }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
