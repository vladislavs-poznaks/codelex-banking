<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\User;
use Livewire\Component;

class SearchAccount extends Component
{
    public $search = '';
    public $accounts = [];

    public function render()
    {
        if (strlen($this->search) > 2) {
            $this->checkAccountNumber();
            $this->checkUserName();
        } else {
            $this->accounts = [];
        }

        return view('livewire.search-account');
    }

    private function checkAccountNumber()
    {
        if (Account::where('number', 'like', '%' . $this->search . '%')->exists()) {
            $this->accounts = Account::where('number', 'like', '%' . $this->search . '%')
                ->take(7)
                ->get();
        }
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
        }
    }
}
