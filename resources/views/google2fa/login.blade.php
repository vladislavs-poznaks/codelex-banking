<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
        </x-slot>

        <form method="POST" action="{{ route('2fa') }}">
        @csrf

        <!-- OTP -->
            <div>
                <x-label for="otp" value="Enter your One Time Password"/>

                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="text"
                    name="one_time_password"
                    required
                    autocomplete="off"
                    autofocus
                />
            </div>
            @error('one_time_password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <div class="flex items-center justify-around mt-4">
                <x-button class="ml-3">
                    {{ __('Confirm') }}
                </x-button>
            </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
