<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\User;
use Livewire\Component;

class SearchAccount extends Component
{
    public $account;
    public $partner;

    public $search = '';
    public $amount = '';
    public $rate = 1;

    public $accounts = [];

    public $dropdownVisible = true;
    public $verifyVisible = false;

    public function render()
    {
        if (strlen($this->search) > 2) {
            if (!$this->checkAccountNumber() && !$this->checkUserName()) {
                $this->accounts = [];
            }
            if ($this->partner && $this->partner->number === $this->search) {
                $this->dropdownVisible = false;
            } else {
                $this->dropdownVisible = true;
            }
        } else {
            $this->accounts = [];
        }

        return view('livewire.search-account');
    }

    public function setAccountNumber(Account $partner)
    {
        $this->partner = $partner;
        $this->search = $partner->number;

        if ($this->partner->currency->isNot($this->account->currency)) {
            $this->rate = $this->partner->currency->rate / $this->account->currency->rate;
        } else {
            $this->rate = 1;
        }
    }

    public function toggleOTP()
    {
        $this->verifyVisible = !$this->verifyVisible;
    }

    private function checkAccountNumber(): bool
    {
        if (Account::where('number', 'like', '%' . $this->search . '%')->exists()) {
            $this->accounts = Account::where('number', 'like', '%' . $this->search . '%')
                ->take(7)
                ->get();

            return true;
        }

        return false;
    }

    private function checkUserName()
    {
        if (User::where('name', 'like', '%' . $this->search . '%')->exists()) {
            $this->accounts = User::where('name', 'like', '%' . $this->search . '%')
                ->with('accounts')
                ->get()
                ->pluck('accounts')
                ->flatten()
                ->take(7);

            return true;
        }

        return false;
    }
}
