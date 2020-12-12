<?php

namespace App\Helpers;

use App\Models\Account;

class AccountNumberGenerator
{
    private string $prefix = 'CB';
    private int $length = 10;

    public function generate(): string
    {
        $accountExists = true;

        while ($accountExists) {
            $accountNumber = $this->prefix . rand(10**($this->length - 1), 10**($this->length) - 1);
            $accountExists = Account::where('number', $accountNumber)->exists();
        }

        return $accountNumber;
    }

    public function withLength(int $length = 10)
    {
        $this->length = $length;

        return $this;
    }

    public function withPrefix(string $prefix = 'CB')
    {
        $this->prefix = $prefix;

        return $this;
    }

}
