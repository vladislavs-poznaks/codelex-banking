<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;
use Illuminate\Database\Seeder;

class UsersAccountsSeeder extends Seeder
{
    public function run()
    {
        (new LatviaBankCurrencyRepository())->updateCurrencies();

        User::factory()->count(10)->create()->each(function ($user) {
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
                'name' => 'Random account #1',
                'funds' => rand(5000, 10000),
            ]);

            Account::factory()->create([
                'user_id' => $user->id,
                'name' => 'Random account #2',
                'funds' => rand(5000, 10000),
            ]);

            Account::factory()->create([
                'user_id' => $user->id,
                'name' => 'Random account #3',
                'funds' => rand(5000, 10000),
            ]);
        });
    }
}
