<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;
use Illuminate\Database\Seeder;

class JohnDoeAccountsSeeder extends Seeder
{
    public function run()
    {
        (new LatviaBankCurrencyRepository())->updateCurrencies();

        $user = User::where('email', 'john.doe@example.com')->first();

        if ($user) {

            Account::factory()->create([
                'user_id' => $user->id,
                'name' => 'Home, sweet home',
                'funds' => 5000,
                'currency_id' => Currency::where('code', 'EUR')->first()->id,
            ]);

            Account::factory()->create([
                'user_id' => $user->id,
                'name' => 'ForBiden',
                'funds' => 5000,
                'currency_id' => Currency::where('code', 'USD')->first()->id,
            ]);

            Account::factory()->create([
                'user_id' => $user->id,
                'name' => 'Gazprom',
                'funds' => 500000,
                'currency_id' => Currency::where('code', 'RUB')->first()->id,
            ]);

            Account::factory()->create([
                'user_id' => $user->id,
                'name' => 'Do u even PHP?',
                'funds' => 10000,
                'currency_id' => Currency::where('code', 'PHP')->first()->id,
            ]);
        }

    }
}
