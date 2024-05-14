<?php

namespace Shota\TaskRefactorCode\Interfaces;

use Shota\TaskRefactorCode\Data\PriceData;

interface CurrencyServiceInterface
{
    public function setBaseCurrency(string $currency): void;

    public function getBaseCurrency(): string;

    public function enableFakeData(): void;

    public function disableFakeData(): void;

    public function getRealRates(): array;

    public function getFakeRates(): array;

    public function getRates(): array;

    public function convertAmount(PriceData $price): PriceData;
}