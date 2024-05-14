<?php

namespace tests\Services;

use PHPUnit\Framework\TestCase;
use Shota\TaskRefactorCode\Data\PriceData;
use Shota\TaskRefactorCode\Services\CalculationService;
use Shota\TaskRefactorCode\Services\ExchangeRatesService\ExchangeRatesService;

class CalculationServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->calculationService = new CalculationService();
        $this->exchangeService = exchange();
        $this->exchangeService->enableFakeData();
    }

    public function testCalculateEuCountryCommission(): void
    {
        $price = new PriceData(100.00, 'USD');

        $calculatedCommission = $this->calculationService->calculateForEuCountry($price);
        $convertedPrice = $this->exchangeService->convertAmount($price);

        $this->assertEquals(round($convertedPrice->amount * $this->calculationService::EU_COUNTRY_COMMISSION, 2), $calculatedCommission->amount);
    }

    public function testCalculateNonEuCountryCommission(): void
    {
        $price = new PriceData(100.00, 'USD');

        $calculatedCommission = $this->calculationService->calculateForNonEuCountry($price);
        $convertedPrice = $this->exchangeService->convertAmount($price);

        $this->assertEquals(round($convertedPrice->amount * $this->calculationService::NON_EU_COUNTRY_COMMISSION, 2), $calculatedCommission->amount);
    }
}