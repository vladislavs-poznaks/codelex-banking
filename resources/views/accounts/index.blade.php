@extends('dashboard')

@section('content')
    <x-account-create :currencies="$currencies"/>
    <div class="w-full mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
        <h3 class="border-b border-gray-300 px-4 py-6">
            My Accounts
        </h3>
        @forelse($accounts as $account)
            <a href="{{ route('accounts.show', $account) }}">
                <div class="{{ $loop->last ? '' : 'border-b border-gray-300' }} px-4 py-4 space-y-2 hover:bg-gray-100 cursor-pointer">
                    <x-account-card :account="$account"/>
                </div>
            </a>
        @empty
            <div class="px-4 py-6">
                No accounts yet... Create one!
            </div>
        @endforelse
    </div>
@endsection
