<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\Currencies\CurrencyRepository;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;
use Illuminate\Database\Seeder;

class UsersTransactionsWithJohnDoeSeeder extends Seeder
{
    public function run()
    {
        app(CurrencyRepository::class)->updateCurrencies();

        $john = User::where('email', 'john.doe@example.com')->first();

        if ($john) {

            $users = User::all()->except($john->id);

            foreach ($users as $user) {
                $account = $john->accounts->random();
                $partner = $user->accounts->random();

                $rate = $partner->currency->rate / $account->currency->rate;

                $amount = rand(25, 200);

                $account->withdraw($amount, $partner);
                $partner->deposit($amount * $rate, $account);
            }

            foreach ($users as $user) {
                $account = $user->accounts->random();
                $partner = $john->accounts->random();

                $rate = $partner->currency->rate / $account->currency->rate;

                $amount = rand(25, 200);

                $account->withdraw($amount, $partner);
                $partner->deposit($amount * $rate, $account);
            }
        }
    }
}
