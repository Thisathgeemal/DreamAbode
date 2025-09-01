<x-guest-layout>
    <x-authentication-card>
        {{-- <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot> --}}

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h2 class="text-3xl font-bold mb-2 text-center text-gray-800">Create an Account</h2>
            <p class="text-sm text-gray-500 text-center mb-6">
                Fill in the details below to register
            </p>

            <!-- Name -->
            <div class="mb-4">
                <x-label for="name" class="font-medium text-gray-700" value="{{ __('Full Name') }}" />
                <x-input id="name"
                    class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-label for="email" class="font-medium text-gray-700" value="{{ __('Email') }}" />
                <x-input id="email"
                    class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- Mobile -->
            <div class="mb-4">
                <x-label for="mobile" class="font-medium text-gray-700" value="{{ __('Mobile Number') }}" />
                <x-input id="mobile"
                    class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    type="tel" name="mobile" :value="old('mobile')" required autocomplete="tel" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-label for="password" class="font-medium text-gray-700" value="{{ __('Password') }}" />
                <x-input id="password"
                    class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-label for="password_confirmation" class="font-medium text-gray-700"
                    value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation"
                    class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <!-- Buttons -->
            <div class="flex items-center justify-between mt-5">
                <a class="text-sm text-gray-600 hover:text-green-600 font-medium" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button
                    class="bg-green-600 hover:bg-green-700 h-10 text-white font-semibold px-6 rounded-lg shadow flex justify-center">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
