<?php

namespace App\Presenters;

use App\Models\Account;

class AccountPresenter
{
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function funds(): string
    {
        return number_format($this->account->funds, 2)
            . ' '
            . $this->account->currency->code;
    }
}
