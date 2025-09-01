<x-guest-layout>
    <x-authentication-card>
        {{-- <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot> --}}

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h2 class="text-3xl font-bold mb-2 text-center poppins">Login</h2>
            <p class="text-sm text-gray-500 text-center mb-6">
                Please enter your credentials to access your account
            </p>

            <div class="mb-4">
                <x-label for="email" class="font-semibold" value="{{ __('Email') }}" />
                <x-input id="email"
                    class="block mt-1 w-full h-10 focus:outline-none focus:ring-green-500 focus:border-green-500"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mb-4">
                <x-label for="password" class="font-semibold" value="{{ __('Password') }}" />
                <x-input id="password"
                    class="block mt-1 w-full h-10 focus:outline-none focus:ring-green-500 focus:border-green-500"
                    type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-between mt-3">
                <label class="flex items-center text-gray-700 text-sm mt-2">
                    <x-checkbox id="remember_me" name="remember"
                        class="h-4 w-4 text-green-500 focus:ring-green-500 rounded" :checked="old('remember')" />
                    <span class="ml-2 font-semibold text-sm">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="inline-block align-baseline font-semibold text-sm text-green-500 hover:text-green-700">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Login button -->
            <div class="mt-5">
                <x-button
                    class="w-full h-10 flex justify-center bg-green-600 hover:bg-green-700 text-white font-semibold px-4 rounded-lg shadow">
                    {{ __('Log in') }}
                </x-button>
            </div>

            <!-- Social Login -->
            <div class="mt-3">
                <p class="text-center text-gray-500 text-sm mb-3">Or continue with</p>
                <div class="flex gap-4">
                    <x-button
                        class="w-1/2 flex justify-center bg-red-500 hover:bg-red-600 text-white h-10 rounded-lg shadow">
                        {{ __('Google') }}
                    </x-button>
                    <x-button
                        class="w-1/2 flex justify-center bg-blue-600 hover:bg-blue-700 text-white h-10 rounded-lg shadow">
                        {{ __('Facebook') }}
                    </x-button>
                </div>
            </div>

            <!-- Register redirect -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-700">
                        Sign up
                    </a>
                </p>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
