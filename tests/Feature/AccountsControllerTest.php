<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use PragmaRX\Google2FALaravel\Middleware;
use Tests\TestCase;

class AccountsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_dashboard()
    {
        $this->actingAs($user = User::factory()->create());

        $this->get(route('dashboard'))
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_user_can_create_an_account()
    {
        $this->actingAs($user = User::factory()->create());
        $this->withoutMiddleware(Middleware::class);

        $currencies = (new LatviaBankCurrencyRepository())->getCurrencies();
        $currency = $currencies->random();

        $this->post(route('accounts.store', [
            'name' => 'Test account',
            'funds' => 1000,
            'currency_id' => $currency->id
        ]))
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('accounts', [
            'name' => 'Test account',
            'funds' => 100000,
            'currency_id' => $currency->id
        ]);
    }

    public function test_funds_are_required_when_creating_an_account()
    {
        $this->actingAs($user = User::factory()->create());
        $this->withoutMiddleware(Middleware::class);

        $currencies = (new LatviaBankCurrencyRepository())->getCurrencies();
        $currency = $currencies->random();

        $this->post(route('accounts.store', [
            'name' => 'Test account',
            'currency_id' => $currency->id
        ]))
            ->assertSessionHasErrors([
                'funds'
            ]);

        $this->assertDatabaseMissing('accounts', [
            'name' => 'Test account',
            'currency_id' => $currency->id
        ]);
    }

    public function test_currency_is_required_when_creating_an_account()
    {
        $this->actingAs($user = User::factory()->create());
        $this->withoutMiddleware(Middleware::class);

        $currencies = (new LatviaBankCurrencyRepository())->getCurrencies();
        $currency = $currencies->random();

        $this->post(route('accounts.store', [
            'name' => 'Test account',
            'funds' => 1000,
        ]))
            ->assertSessionHasErrors([
                'currency_id'
            ]);

        $this->assertDatabaseMissing('accounts', [
            'name' => 'Test account',
            'currency_id' => $currency->id
        ]);
    }

    public function test_user_can_view_a_particular_account()
    {
        $this->actingAs($user = User::factory()->create());
        $this->withoutMiddleware(Middleware::class);

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test account',
        ]);

        $this->get(route('accounts.show', [
            'account' => $account
        ]))
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_user_can_not_view_other_user_account()
    {
        $this->actingAs($user = User::factory()->create());
        $this->withoutMiddleware(Middleware::class);

        $account = Account::factory()->create();

        $this->get(route('accounts.show', [
            'account' => $account
        ]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
