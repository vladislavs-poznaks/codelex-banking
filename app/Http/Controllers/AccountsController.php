<?php

namespace App\Http\Controllers;

use App\Helpers\AccountNumberGenerator;
use App\Http\Requests\AccountStoreRequest;
use App\Models\Account;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;

class AccountsController extends Controller
{
    public function index(LatviaBankCurrencyRepository $repository)
    {
        return view('accounts.index', [
            'accounts' => auth()->user()->accounts,
            'currencies' => $repository->getCurrencies()
        ]);
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account);

        return view('accounts.show', [
            'account' => $account,
            'transactions' => $account->transactions->sortByDesc('created_at')
        ]);
    }

    public function store(AccountStoreRequest $request, AccountNumberGenerator $generator)
    {
        $request->request->add([
            'number' => $generator->generate()
        ]);

        auth()->user()->accounts()->create($request->all());

        return redirect(route('dashboard'));
    }
}
