<?php

return [
    'provider' => \Shota\TaskRefactorCode\Services\ExchangeRatesService\ExchangeRatesService::class,

    'access_key' => '',

    'base_url' => 'http://api.exchangeratesapi.io/v1',

    'base_currency' => 'EUR',

    'fake_data_path' => 'fake/exchange_rates_eur.json'
];