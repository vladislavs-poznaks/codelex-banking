<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;
use Illuminate\Database\Seeder;

class JohnDoeTransactionsSeeder extends Seeder
{
    public function run()
    {
        (new LatviaBankCurrencyRepository())->updateCurrencies();

        $user = User::where('email', 'john.doe@example.com')->first();

        if ($user) {
            foreach (range(1,10) as $iteration) {
                $accounts = $user->accounts->random(2);

                $account = $accounts->first();
                $partner = $accounts->last();

                $rate = $partner->currency->rate / $account->currency->rate;

                $amount = rand(25, 200);

                $account->withdraw($amount, $partner);
                $partner->deposit($amount * $rate, $account);
            }
        }
    }
}
