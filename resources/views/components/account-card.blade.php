<div class="space-y-1">
    <div class="flex justify-between">
        <div>
            Account {{ $account->name ? ': ' . $account->name : ''}}
        </div>
        <div>
            {{ $account->present()->funds() }}
        </div>
    </div>
    <div class="text-sm">
        {{ $account->number }}
    </div>
</div>
