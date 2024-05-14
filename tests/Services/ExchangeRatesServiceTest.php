<?php

namespace tests\Services;

use PHPUnit\Framework\TestCase;
use Shota\TaskRefactorCode\Data\PriceData;
use Shota\TaskRefactorCode\Services\ExchangeRatesService\ExchangeRatesService;

class ExchangeRatesServiceTest extends TestCase
{
    protected ExchangeRatesService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = exchange();
        $this->service->enableFakeData();
    }

    public function testGetRates(): void
    {
        $rates = $this->service->getRates();

        $this->assertIsArray($rates);
    }

    public function testConvertAmount(): void
    {
        $fromCurrency = 'GBP';
        $price = new PriceData(amount: '1', currency: $fromCurrency);

        $convertedFromService = $this->service->convertAmount($price);
        $currencyRate = $this->service->getRates()[$fromCurrency];

        $this->assertEquals($convertedFromService->amount, $price->amount / $currencyRate);
    }

    public function testConvertDifferentCurrencyAmount(): void
    {
        $currency = 'USD';
        $this->service->setBaseCurrency($currency);

        $price = new PriceData(amount: '1', currency: 'EUR');

        $converted = $this->service->convertAmount($price);

        $this->assertEquals($this->service->getBaseCurrency(), $currency);
        $this->assertEquals($currency, $converted->currency);
    }
}