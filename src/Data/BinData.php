<?php
namespace Shota\TaskRefactorCode\Data;

class BinData
{
    public function __construct(public string $scheme, public string $bankName, public CountryData $country)
    {
    }
}