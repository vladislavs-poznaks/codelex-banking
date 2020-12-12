<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Account $account)
    {
        return $account->user->is($user);
    }

    public function update(User $user, Account $account)
    {
        return $account->user->is($user);
    }
}
