<section>
    <header>
        <h2 class="heading">
            {{ __('Update Personal Information') }}
        </h2>

        <p class="heading-medium">
            {{ __('Ensure that all entered data is correct.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div>
            <x-input-label for="current_password" :value="__('Current Phone Number')" />
            <x-text-input id="current_password" name="phone_number" type="text" class="mt-1 block w-full" value="{{ Auth::user()->address }}" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
