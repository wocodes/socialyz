<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <h1 class="text-2xl font-bold">{{ config('app.name') }}</h1>
            </a>
        </x-slot>


        <div class="text-center">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="username" :value="__('Code (BWC 4 digit phone number)')" />

                <x-input id="username" class="block mt-1 w-full" type="text" maxlength="4" name="username" :value="old('username')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
