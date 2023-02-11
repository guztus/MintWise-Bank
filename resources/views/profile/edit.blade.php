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


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <x-message-or-error/>
        <div class="card-standard">
            <div class="max-w-xl">
                <a class="heading">Security Codes</a>
                <div class="flex mt-4"
                     style="flex-wrap: wrap; gap: 1em 1.6em; justify-content: center; align-items: center">
                    @foreach($codes as $code)
                        <div class="code" x-data="{ open: false }" x-on:mouseenter="open = true"
                             x-on:mouseleave="open = false">
                            <span x-show="!open">{{ $loop->index+1 }}.</span>
                            <span x-show="open">{{ $code }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 mb-4">
                    <a class="btn my-3" style="margin-top: 8em !important;" href="{{ route('profile.resetCodes') }}">
                        Generate new codes
                    </a>
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

        <div class="card-standard">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
