<?php

namespace App\Repositories\Currencies;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;
use Sabre\Xml\Service;

class LatviaBankCurrencyRepository implements CurrencyRepository
{
    private $url = 'https://www.bank.lv/vk/ecb.xml';
    private Service $service;

    public function __construct()
    {
        $this->service = new Service();
    }

    public function getCurrencies()
    {
        return Cache::remember('currencies', 600, function () {
            $this->updateCurrencies();

            return Currency::all();
        });
    }

    public function updateCurrencies()
    {
        $xml = file_get_contents($this->url);
        $currencies = $this->service->parse($xml)['1']['value'];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['code' => $currency['value'][0]['value']],
                ['rate' => $currency['value'][1]['value']],
            );
        }

        Currency::updateOrCreate(
            ['code' => 'EUR'],
            ['rate' => 1]
        );
    }
}
