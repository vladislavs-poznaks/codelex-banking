<div class="border border-gray-700 rounded-lg mt-10">

    <div class="space-y-6 px-4 py-6">
        <x-account-card :account="$account"/>
    </div>


{{--    <form action="{{ route('wallets.update', ['wallet' => $wallet]) }}" method="POST" class="space-y-6">--}}

{{--        @method('PATCH')--}}
{{--        @csrf--}}

{{--        <div class="flex items-center">--}}
{{--            <label--}}
{{--                for="name"--}}
{{--                class="w-2/6"--}}
{{--            >Rename this wallet</label>--}}
{{--            <input--}}
{{--                type="text"--}}
{{--                id="name"--}}
{{--                name="name"--}}
{{--                placeholder="Enter a unique wallet's name..."--}}
{{--                required--}}
{{--                class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline px-3 py-2 ml-4 w-4/6"--}}
{{--            >--}}
{{--            <button--}}
{{--                type="submit"--}}
{{--                class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125 ml-6"--}}
{{--            >Save</button>--}}
{{--        </div>--}}
{{--        @error('name')--}}
{{--        <div class="text-sm text-red-500">{{ $message }}</div>--}}
{{--        @enderror--}}
{{--    </form>--}}

{{--    <form action="{{ route('wallets.destroy', ['wallet' => $wallet]) }}" method="POST" class="mt-4">--}}
{{--        @method('DELETE')--}}
{{--        @csrf--}}

{{--        <div class="text-right text-sm text-red-500">--}}
{{--            <button--}}
{{--                type="submit"--}}
{{--                class="hover:underline"--}}
{{--            >Delete this wallet</button>--}}
{{--        </div>--}}
{{--    </form>--}}

</div>



