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
            flex-basis: 30%;
            text-align: center;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card-standard">
                <div class="max-w-xl">
                    <a class="heading">Your security codes:</a>
                    <div class="flex mt-4"
                         style="flex-wrap: wrap; gap: 1em; justify-content: center; align-items: center">
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">1.</span>
                            <span x-show="open">{{ $codeCard->code_1 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">2.</span>
                            <span x-show="open">{{ $codeCard->code_2 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">3.</span>
                            <span x-show="open">{{ $codeCard->code_3 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">4.</span>
                            <span x-show="open">{{ $codeCard->code_4 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">5.</span>
                            <span x-show="open">{{ $codeCard->code_5 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">6.</span>
                            <span x-show="open">{{ $codeCard->code_6 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">7.</span>
                            <span x-show="open">{{ $codeCard->code_7 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">8.</span>
                            <span x-show="open">{{ $codeCard->code_8 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">9.</span>
                            <span x-show="open">{{ $codeCard->code_9 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">10.</span>
                            <span x-show="open">{{ $codeCard->code_10 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">11.</span>
                            <span x-show="open">{{ $codeCard->code_11 }}</span>
                        </div>
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">12.</span>
                            <span x-show="open">{{ $codeCard->code_12 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-standard">
                <div class="heading">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card-standard">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

{{--            <div class="card-standard">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.update-personal-info-form')--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="card-standard">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
