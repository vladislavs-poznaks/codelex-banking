<?php

namespace App\Presenters;

use App\Models\Transaction;

class TransactionPresenter
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function funds(): string
    {
        return ($this->transaction->isIncoming() ? '+' : '')
            . number_format($this->transaction->funds, 2)
            . ' '
            . $this->transaction->account->currency->code;
    }

    public function details(): string
    {
        return ($this->transaction->isIncoming() ? 'from ' : 'to ')
            . ($this->transaction->partner->user->is($this->transaction->account->user)
                ? 'My Account'
                : $this->transaction->partner->user->name)
            . ', '
            . $this->transaction->partner->number
            . ' ('
            . $this->transaction->partner->currency->code
            . ')';
    }
}
