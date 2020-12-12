<?php

namespace Database\Factories;

use App\Helpers\AccountNumberGenerator;
use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'number' => (new AccountNumberGenerator())->generate(),
            'name' => $this->faker->words($count = 2, $asText = true),
            'currency_id' => Currency::factory(),
            'funds' => $this->faker->randomNumber(5),
        ];
    }
}
