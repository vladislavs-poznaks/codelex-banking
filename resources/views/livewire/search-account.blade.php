<form
    action="{{ route('accounts.transactions.store', $account) }}"
    method="POST"
    class="relative space-y-6 px-4 py-6"
    autocomplete="off"
>
    @csrf


    <div class="text-sm space-y-2">
        @if($partner && !$dropdownVisible)
            <div>
                Recipient's name: {{ $partner->user->name }}
            </div>
            <div>
                Account's currency: {{ $partner->currency->code }}
            </div>
            @if($amount > 0)
                <div>
                    Transfer amount: {{ number_format($amount, 2) . ' ' . $account->currency->code }}
                    {{ $rate !== 1 ? '(' . number_format($amount * $rate, 2) . ' ' . $partner->currency->code . ')' : '' }}
                </div>
            @endif
        @endif
    </div>


    <div>
        <x-label for="partner">Recipient's account</x-label>
        <input
            id="partner"
            class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="text"
            name="partner"
            wire:model.debounce.300ms="search"
            placeholder="Enter account's number"
            {{ $verifyVisible ? 'readonly' : '' }}
            value="old('recipient')"
            autofocus
        >
        @error('partner')
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    @if(strlen($search) > 2 && $dropdownVisible)
        <div
            id="dropdown"
            class=" box-border absolute z-50 w-full text-sm mt-6 px-6 py-4 bg-white shadow-xl sm:rounded-lg"
        >
            <ul>
                @forelse($accounts as $account)
                    <li class="{{ $loop->last ? '' : 'border-b' }} border-gray-300 py-2">
                        <div
                            class="space-y-1 cursor-pointer"
                            wire:click="setAccountNumber({{ $account }})"
                        >
                            <div class="flex justify-between">
                                <div>
                                    {{ $account->user->is(auth()->user()) ? 'My account' : $account->user->name }}
                                </div>
                                <div>
                                    {{ $account->currency->code . ' account' }}
                                </div>
                            </div>
                            <div>
                                {{ $account->number }}
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="border-gray-700 px-2 py-2">
                        No accounts match "{{ $search }}".
                    </li>
                @endforelse
            </ul>
        </div>
    @endif

    <div>
        <x-label for="amount">Amount</x-label>
        <input
            id="amount"
            class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="number"
            name="amount"
            wire:model.debounce.300ms="amount"
            min="1"
            max="{{ $account->funds }}"
            placeholder="Enter amount"
            {{ $verifyVisible ? 'readonly' : '' }}
            step=".01"
            value="old('amount')"
            required
        >
        @error('amount')
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        @error('one_time_password')
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    @if(!$verifyVisible)
        <div class="text-center">
            <x-button
                onclick="event.preventDefault()"
                wire:click="toggleOTP"
            >Continue
            </x-button>
        </div>
    @else
        <div>
            <x-label for="one_time_password">One Time Password</x-label>
            <x-input
                id="one_time_password"
                class="block mt-1 w-full"
                type="text"
                name="one_time_password"
                placeholder="Enter One Time Password"
                required
            />
        </div>
        <div class="flex justify-around">
            <div class="flex items-center space-x-3">
                <x-button
                    onclick="event.preventDefault()"
                    wire:click="toggleOTP"
                >
                    Edit
                </x-button>
                <x-button>
                    Send funds
                </x-button>
            </div>
        </div>
    @endif
</form>
