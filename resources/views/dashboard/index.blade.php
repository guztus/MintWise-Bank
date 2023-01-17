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
    <div class="center" style="width: 60%; height: 60%; text-align: center">
        <div class="card-standard pb-4">
            <div class="p-6 text-gray-900">
                <a class="heading">Your security codes:</a>
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
                        <button class="btn">
                            Reset my codes
                        </button>
        </div>
    </div>
</x-app-layout>
