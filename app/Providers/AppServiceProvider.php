<?php

namespace App\Providers;

use App\Repositories\Currencies\CurrencyRepository;
use App\Repositories\Currencies\LatviaBankCurrencyRepository;
use Illuminate\Support\ServiceProvider;
use Sabre\Xml\Service;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CurrencyRepository::class, function () {
            return new LatviaBankCurrencyRepository(new Service());
        });
    }
}
