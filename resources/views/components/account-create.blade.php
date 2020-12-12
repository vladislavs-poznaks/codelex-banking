<div class="border border-gray-700 rounded-lg mt-10">
    <form action="{{ route('accounts.store') }}" method="POST" class="space-y-6 px-4 py-6">
        @csrf

        <div>
            <x-label for="name">Account's name</x-label>
            <x-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                placeholder="Enter accunt's name (optional)"
                :value="old('name')"
            />
            @error('name')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between space-x-2">
            <div class="w-5/6">
                <x-label for="funds">Funds</x-label>
                <x-input
                    id="funds"
                    class="block mt-1 w-full"
                    type="number"
                    name="funds"
                    placeholder="Enter funds"
                    :value="old('funds')"
                    required
                />
            </div>
            <div class="w-1/6">
                <x-label for="currency_id">Currency</x-label>
                <select name="currency_id" id="currency_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->id }}" {{ $currency->code === 'EUR' ? 'selected' : '' }}>
                            {{ $currency->code }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="text-center">
            <x-button>Create Account</x-button>
        </div>
    </form>
</div>
