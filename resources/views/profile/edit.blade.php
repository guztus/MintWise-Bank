<x-app-layout>
    <style>
        .number {
            color: #474747;
            font-weight: bold
        }

        .code {
            background-color: #f5f5f5;
            border: 1px solid #e8e8e8;
            border-radius: 3px;
            color: #333;
            padding: 6px;
            flex-basis: 30%
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <a class="text-lg font-medium text-gray-900">Your security codes:</a>
                    <div class="flex mt-4"
                         style="flex-wrap: wrap; gap: 1em; justify-content: center; align-items: center">
                        <span class="code">1. {{ $codeCard->code_1 }}</span>
                        <span class="code">2. {{ $codeCard->code_2 }}</span>
                        <span class="code">3. {{ $codeCard->code_3 }}</span>
                        <span class="code">4. {{ $codeCard->code_4 }}</span>
                        <span class="code">5. {{ $codeCard->code_5 }}</span>
                        <span class="code">6. {{ $codeCard->code_6 }}</span>
                        <span class="code">7. {{ $codeCard->code_7 }}</span>
                        <span class="code">8. {{ $codeCard->code_8 }}</span>
                        <span class="code">9. {{ $codeCard->code_9 }}</span>
                        <span class="code">10. {{ $codeCard->code_10 }}</span>
                        <span class="code">11. {{ $codeCard->code_11 }}</span>
                        <span class="code">12. {{ $codeCard->code_12 }}</span>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
