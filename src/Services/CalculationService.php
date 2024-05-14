<?php
namespace Shota\TaskRefactorCode\Services;

use Shota\TaskRefactorCode\Data\PriceData;
use Shota\TaskRefactorCode\Interfaces\BinServiceInterface;
use Shota\TaskRefactorCode\Interfaces\CurrencyServiceInterface;
use Shota\TaskRefactorCode\Services\BinListService\BinListService;
use Shota\TaskRefactorCode\Services\ExchangeRatesService\ExchangeRatesService;

class CalculationService
{
    protected CurrencyServiceInterface $currencyService;
    protected BinServiceInterface $binService;

    public const EU_COUNTRY_COMMISSION = 0.01;
    public const NON_EU_COUNTRY_COMMISSION = 0.02;

    public function __construct()
    {
        $this->currencyService = exchange();
        $this->binService = bin();
    }

    public function calculateForEuCountry(PriceData $priceData): PriceData
    {
        $convertedPrice = $this->currencyService->convertAmount($priceData);

        return $this->calculateCommission($convertedPrice, $priceData, self::EU_COUNTRY_COMMISSION);
    }

    public function calculateForNonEuCountry(PriceData $priceData): PriceData
    {
        $convertedPrice = $this->currencyService->convertAmount($priceData);

        return $this->calculateCommission($convertedPrice, $priceData, self::NON_EU_COUNTRY_COMMISSION);
    }

    protected function calculateCommission($convertedPrice, $originalPrice, $rate): PriceData
    {
        $precisionCount = get_precision_count($originalPrice->amount) > 2 ?: 2;

        return new PriceData(round($convertedPrice->amount * $rate, $precisionCount), $originalPrice->currency);
    }
}