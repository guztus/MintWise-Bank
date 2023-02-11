<section>
    <header>
        <h2 class="heading">
            {{ __('Profile Information') }}
        </h2>

        <p class="heading-medium">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autocomplete="name"/>
            <x-input-error
                class="mt-2"
                :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="email"/>
            <x-input-error
                class="mt-2"
                :messages="$errors->get('email')"/>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="btn">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label
                for="address"
                :value="__('Address')"/>
            <x-text-input
                id="address"
                address="address"
                type="text"
                name="address"
                class="mt-1 block w-full"
                :value="old('address', $user->address)"
                required
                autocomplete="address-line1"/>
            <x-input-error
                class="mt-2"
                :messages="$errors->get('address')"/>
        </div>

        <div>
            <x-input-label
                for="phone_number"
                :value="__('Phone Number')"/>
            <x-text-input
                id="phone_number"
                phone_number="phone_number"
                type="text"
                name="phone-number"
                class="mt-1 block w-full"
                :value="old('phone_number', $user->phone_number)"
                required
                autocomplete="tel"/>
            <x-input-error
                class="mt-2"
                :messages="$errors->get('phone_number')"/>
        </div>

        <div class="border-t-2 pt-2">
            <x-input-label for="password" :value="__('Password to confirm')"/>

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                placeholder="Password"
                required
                autocomplete="current-password"/>

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
