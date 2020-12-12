<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
        </x-slot>
        <div class="text-center space-y-2">
            <div>
                Set up Google Authenticator
            </div>
            <div>
                <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                <div class="flex justify-around mx-auto my-4">
                    {!! QrCode::size(150)->style('round')->generate($url); !!}
                </div>
                <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                <a href="/registration">
                    <x-button class="mt-3">
                        {{ __('Complete Registration') }}
                    </x-button>
                </a>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
