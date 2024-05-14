<?php
namespace Shota\TaskRefactorCode\Data;

class PriceData
{
    public function __construct(public float $amount, public string $currency)
    {
    }
}