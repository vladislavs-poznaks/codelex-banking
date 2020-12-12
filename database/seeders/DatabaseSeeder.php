<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            JohnDoeAccountsSeeder::class,
            JohnDoeTransactionsSeeder::class,
            UsersAccountsSeeder::class,
            UsersTransactionsWithJohnDoeSeeder::class,
        ]);
    }
}
