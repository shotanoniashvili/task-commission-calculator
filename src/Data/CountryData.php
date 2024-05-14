<?php
namespace Shota\TaskRefactorCode\Data;

class CountryData
{
    public function __construct(public string $name, public string $code, public string $currency)
    {
    }
}