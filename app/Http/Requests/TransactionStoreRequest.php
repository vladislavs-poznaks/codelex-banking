<?php

namespace App\Http\Requests;

use App\Rules\AccountHasSufficientFunds;
use App\Rules\OneTimePasswordIsValid;
use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'partner' => ['required', 'exists:accounts,number', 'not_in:' . $this->account->number],
            'amount' => ['required', 'gte:1', new AccountHasSufficientFunds($this->account)],
            'one_time_password' => ['required', new OneTimePasswordIsValid($this)],
        ];
    }

    public function messages()
    {
        return [
            'partner.required' => 'Account number is required',
            'partner.exists' => 'Account number is invalid',
            'partner.not_in' => 'Recipient\'s account must differ from current.'
        ];
    }
}
