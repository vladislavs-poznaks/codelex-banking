<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Models\Account;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;

class TransactionsController extends Controller
{
    public function store(
        TransactionStoreRequest $request,
        Account $account,
        LatviaBankCurrencyRepository $repository
    ) {
        $this->authorize('update', $account);

        $repository->getCurrencies();

        $partner = Account::where('number', $request->partner)->first();

        $rate = $partner->currency->rate / $account->currency->rate;

        $account->withdraw($request->amount, $partner);
        $partner->deposit($request->amount * $rate, $account);

        return redirect(route('accounts.show', [
            'account' => $account
        ]));
    }
}
