<div>
    <div id="recipient" class="text-sm mb-2 hidden">
        Recipient's name: {{ count($accounts) > 0
            ? ($accounts[0]->user->is(auth()->user()) ? 'Myself' : $accounts[0]->user->name)
            : ''}}
    </div>

    <x-label for="partner">Recipient's account</x-label>
    <x-input
        id="partner"
        class="block mt-1 w-full"
        type="text"
        name="partner"
        wire:model.debounce.300ms="search"
        placeholder="Enter account's number"
        :value="old('recipient')"
    />
    @error('partner')
    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
    @enderror

    @if(strlen($search) > 2)
        <div
            id="dropdown"
            class="absolute z-50 text-sm bg-gray-100 border border-gray-900 rounded w-1/3 mt-2 display-none"
        >
            <ul>
                @forelse($accounts as $account)
                    <li class="{{ $loop->last ? '' : 'border-b' }} border-gray-700 px-2 py-2">
                        <div
                            class="space-y-1 cursor-pointer"
                            onclick="setAccountNumber('{{ $account->number }}')"
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
                        There are no accounts with number "{{ $search }}".
                    </li>
                @endforelse
            </ul>
        </div>
    @endif
    <script type="text/javascript">
        const setAccountNumber = (accountNumber) => {
            document.getElementById('partner').value = accountNumber
            document.getElementById('dropdown').style.display = 'none'

            if (document.getElementById('dropdown').style.display === 'none') {
                document.getElementById('recipient').style.display = 'block'
            } else {
                document.getElementById('recipient').style.display = 'none'
            }
        }
    </script>
</div>
