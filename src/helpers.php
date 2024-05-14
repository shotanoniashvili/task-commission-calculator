<?php

use Shota\TaskRefactorCode\Interfaces\BinServiceInterface;
use Shota\TaskRefactorCode\Interfaces\CurrencyServiceInterface;
use Shota\TaskRefactorCode\Services\CalculationService;

if (!function_exists('is_eu_country')) {
    function is_eu_country(string $countryCode): bool
    {
        $euCountryCodes = require 'config/eu_countries.php';

        return in_array(strtolower($countryCode), $euCountryCodes);
    }
}

if (!function_exists('get_precision_count')) {
    function get_precision_count(float $number): int
    {
        return (int)strpos(strrev($number), '.');
    }
}

if (!function_exists('bin')) {
    function bin(): BinServiceInterface
    {
        $binServiceConfig = require 'config/bin.php';

        return new $binServiceConfig['provider'];
    }
}

if (!function_exists('exchange')) {
    function exchange(): CurrencyServiceInterface
    {
        $binServiceConfig = require 'config/currency.php';

        return new $binServiceConfig['provider'];
    }
}

if (!function_exists('calculation')) {
    function calculation(): CalculationService
    {
        return new CalculationService();
    }
}