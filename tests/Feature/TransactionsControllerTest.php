<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Facades\PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FALaravel\Middleware;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_transaction_between_accounts()
    {
        $this->actingAs($user = User::factory()->create([
            'google2fa_secret' => Google2FA::generateSecretKey()
        ]));
        $this->withoutMiddleware(Middleware::class);

        app(CurrencyRepository::class)->updateCurrencies();
        $currency = Currency::where('code', 'EUR')->first();

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'funds' => 1000,
            'currency_id' => $currency->id
        ]);

        $partner = Account::factory()->create([
            'funds' => 10,
            'currency_id' => $currency->id
        ]);

        $this->post(route('accounts.transactions.store', [
            'account' => $account
        ]), [
            'partner' => $partner->number,
            'amount' => 100,
            'one_time_password' => Google2FA::getCurrentOtp($user->google2fa_secret)
        ])
            ->assertRedirect(route('accounts.show', $account));

        $this->assertDatabaseHas('transactions', [
            'account_id' => $account->id,
            'partner_account_id' => $partner->id,
            'funds' => -10000,
        ]);

        $this->assertDatabaseHas('transactions', [
            'account_id' => $partner->id,
            'partner_account_id' => $account->id,
            'funds' => 10000,
        ]);
    }

    public function test_user_can_not_exceed_account_funds()
    {
        $this->actingAs($user = User::factory()->create([
            'google2fa_secret' => Google2FA::generateSecretKey()
        ]));

        $this->withoutMiddleware(Middleware::class);

        app(CurrencyRepository::class)->updateCurrencies();
        $currency = Currency::where('code', 'EUR')->first();

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'funds' => 10,
            'currency_id' => $currency->id
        ]);

        $partner = Account::factory()->create([
            'funds' => 10,
            'currency_id' => $currency->id
        ]);

        $this->post(route('accounts.transactions.store', [
            'account' => $account
        ]), [
            'partner' => $partner->number,
            'amount' => 100,
            'one_time_password' => Google2FA::getCurrentOtp($user->google2fa_secret)
        ])
            ->assertSessionHasErrors('amount');

        $this->assertDatabaseMissing('transactions', [
            'account_id' => $account->id,
            'partner_account_id' => $partner->id,
            'funds' => -10000,
        ]);

        $this->assertDatabaseMissing('transactions', [
            'account_id' => $partner->id,
            'partner_account_id' => $account->id,
            'funds' => 10000,
        ]);
    }

    public function test_user_can_not_transfer_funds_between_one_account()
    {
        $this->actingAs($user = User::factory()->create([
            'google2fa_secret' => Google2FA::generateSecretKey()
        ]));
        $this->withoutMiddleware(Middleware::class);

        app(CurrencyRepository::class)->updateCurrencies();
        $currency = Currency::where('code', 'EUR')->first();

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'funds' => 10,
            'currency_id' => $currency->id
        ]);

        $this->post(route('accounts.transactions.store', [
            'account' => $account
        ]), [
            'partner' => $account->number,
            'amount' => 100,
            'one_time_password' => Google2FA::getCurrentOtp($user->google2fa_secret)
        ])
            ->assertSessionHasErrors('partner');

        $this->assertDatabaseMissing('transactions', [
            'account_id' => $account->id,
            'partner_account_id' => $account->id,
            'funds' => -10000,
        ]);

        $this->assertDatabaseMissing('transactions', [
            'account_id' => $account->id,
            'partner_account_id' => $account->id,
            'funds' => 10000,
        ]);
    }

    public function test_user_can_not_transfer_funds_from_other_user_account()
    {
        $this->actingAs($user = User::factory()->create([
            'google2fa_secret' => Google2FA::generateSecretKey()
        ]));
        $this->withoutMiddleware(Middleware::class);

        app(CurrencyRepository::class)->updateCurrencies();
        $currency = Currency::where('code', 'EUR')->first();

        $account = Account::factory()->create([
            'funds' => 1000,
            'currency_id' => $currency->id
        ]);

        $partner = Account::factory()->create([
            'funds' => 1000,
            'currency_id' => $currency->id
        ]);

        $this->post(route('accounts.transactions.store', [
            'account' => $account
        ]), [
            'partner' => $partner->number,
            'amount' => 100,
            'one_time_password' => Google2FA::getCurrentOtp($user->google2fa_secret)
        ])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_can_create_a_transaction_between_accounts_with_different_currencies()
    {
        $this->actingAs($user = User::factory()->create([
            'google2fa_secret' => Google2FA::generateSecretKey()
        ]));
        $this->withoutMiddleware(Middleware::class);

        app(CurrencyRepository::class)->updateCurrencies();
        $usd = Currency::where('code', 'USD')->first();
        $rub = Currency::where('code', 'RUB')->first();

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'funds' => 1000,
            'currency_id' => $usd->id
        ]);

        $partner = Account::factory()->create([
            'funds' => 10,
            'currency_id' => $rub->id
        ]);

        $this->post(route('accounts.transactions.store', [
            'account' => $account
        ]), [
            'partner' => $partner->number,
            'amount' => 100,
            'one_time_password' => Google2FA::getCurrentOtp($user->google2fa_secret)
        ])
            ->assertRedirect(route('accounts.show', $account));

        $this->assertDatabaseHas('transactions', [
            'account_id' => $account->id,
            'partner_account_id' => $partner->id,
            'funds' => -10000,
        ]);

        $rate = $partner->currency->rate / $account->currency->rate;

        $this->assertDatabaseHas('transactions', [
            'account_id' => $partner->id,
            'partner_account_id' => $account->id,
            'funds' => round(10000 * $rate, 0),
        ]);
    }

    public function test_user_can_not_create_a_transaction_without_valid_one_time_password()
    {
        $this->actingAs($user = User::factory()->create([
            'google2fa_secret' => Google2FA::generateSecretKey()
        ]));

        $this->withoutMiddleware(Middleware::class);

        app(CurrencyRepository::class)->updateCurrencies();
        $currency = Currency::where('code', 'EUR')->first();

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'funds' => 10,
            'currency_id' => $currency->id
        ]);

        $partner = Account::factory()->create([
            'funds' => 10,
            'currency_id' => $currency->id
        ]);

        $this->post(route('accounts.transactions.store', [
            'account' => $account
        ]), [
            'partner' => $partner->number,
            'amount' => 100,
            'one_time_password' => '123123'
        ])
            ->assertSessionHasErrors('one_time_password');

        $this->assertDatabaseMissing('transactions', [
            'account_id' => $account->id,
            'partner_account_id' => $partner->id,
            'funds' => -10000,
        ]);

        $this->assertDatabaseMissing('transactions', [
            'account_id' => $partner->id,
            'partner_account_id' => $account->id,
            'funds' => 10000,
        ]);
    }
}
