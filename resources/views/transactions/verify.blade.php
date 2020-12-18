@extends('dashboard')

@section('content')
    <x-account-edit :account="$account"/>

    <x-transaction-verify :account="$account"/>

{{--    <div class="w-full mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">--}}
{{--        <h3 class="border-b border-gray-300 px-4 py-6">--}}
{{--            Transactions--}}
{{--        </h3>--}}

{{--        @forelse($transactions as $transaction)--}}
{{--            <div class="{{ $loop->last ? '' : 'border-b border-gray-300' }} text-sm px-4 py-4 space-y-2">--}}
{{--                <div class="space-y-2">--}}
{{--                    <div class="flex justify-between items-center">--}}
{{--                        <div class="flex space-x-3 items-center">--}}
{{--                            <span class="text-{{ $transaction->isIncoming() ? 'green' : 'red' }}-600--}}
{{--                            bg-{{ $transaction->isIncoming() ? 'green' : 'red' }}-100--}}
{{--                            px-3 py-1 rounded-full font-semibold">--}}
{{--                                {{ $transaction->present()->funds() }}--}}
{{--                            </span>--}}
{{--                            <span>--}}
{{--                                {{ $transaction->present()->details() }}--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <span>--}}
{{--                                {{ $transaction->created_at->diffForHumans() }}--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        @empty--}}
{{--            <div class="text-sm px-4 py-6">--}}
{{--                No transactions with this account...--}}
{{--            </div>--}}
{{--        @endforelse--}}
{{--    </div>--}}
@endsection
