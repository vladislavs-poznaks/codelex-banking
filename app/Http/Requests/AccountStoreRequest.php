<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'nullable|string|min:5|max:30',
            'funds' => 'required|integer',
            'currency_id' => 'required|exists:currencies,id',
        ];
    }
}
