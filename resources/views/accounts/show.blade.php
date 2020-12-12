@extends('dashboard')

@section('content')
    <x-account-edit :account="$account"/>
    <x-transaction-create :account="$account"/>

    <div class="border border-gray-700 rounded-lg mt-10">
        <h3 class="border-b border-gray-700 px-4 py-6">
            Transactions
        </h3>

        @forelse($transactions as $transaction)
            <div class="{{ $loop->last ? '' : 'border-b border-gray-700' }} text-sm px-4 py-4 space-y-2">
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-3">
                            <span class="text-{{ $transaction->isIncoming() ? 'green' : 'red' }}-500">
                                {{ $transaction->present()->funds() }}
                            </span>
                            <span>
                                {{ $transaction->present()->details() }}
                            </span>
                        </div>
                        <div>
                            <span>
                                {{ $transaction->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="text-sm px-4 py-6">
                No transactions with this account...
            </div>
        @endforelse
    </div>
@endsection
