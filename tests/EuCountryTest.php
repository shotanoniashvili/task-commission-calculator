<?php

namespace tests;

use PHPUnit\Framework\TestCase;

class EuCountryTest extends TestCase
{
    protected string $configPath = 'config/eu_countries.php';

    public function testCanReadCountriesConfig(): void
    {
        $this->assertFileExists($this->configPath);

        $countryList = require $this->configPath;
        $this->assertIsArray($countryList);
    }

    public function testIsEuCountry(): void
    {
        $this->assertTrue(is_eu_country('FR'));
        $this->assertTrue(is_eu_country('nl'));
    }

    public function testIsNotEuCountry(): void
    {
        $this->assertFalse(is_eu_country('CN'));
        $this->assertFalse(is_eu_country('eg'));
    }
}