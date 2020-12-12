<div class="border border-gray-700 rounded-lg mt-10">
    <form
        action="{{ route('accounts.transactions.store', $account) }}"
        method="POST"
        class="space-y-6 px-4 py-6"
        autocomplete="off"
    >
        @csrf

        <livewire:search-account />

        <div>
            <x-label for="amount">Amount</x-label>
            <x-input
                id="amount"
                class="block mt-1 w-full"
                type="number"
                name="amount"
                min="1"
{{--                max="{{ $account->funds }}"--}}
                placeholder="Enter amount"
                :value="old('amount')"
{{--                required--}}
            />
            @error('amount')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="text-center">
            <x-button>Send Funds</x-button>
        </div>
    </form>
</div>
