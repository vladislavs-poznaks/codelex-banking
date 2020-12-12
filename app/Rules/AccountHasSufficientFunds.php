<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class AccountHasSufficientFunds implements Rule
{
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function passes($attribute, $value)
    {
        return $this->account->getFundsAttribute() >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Insufficient funds.';
    }
}
