<?php

namespace App\Repositories\Currencies;

interface CurrencyRepository
{
    public function getCurrencies();

    public function updateCurrencies();
}
