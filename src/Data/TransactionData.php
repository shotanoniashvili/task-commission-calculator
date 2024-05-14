<?php
namespace Shota\TaskRefactorCode\Data;

class TransactionData
{
    public function __construct(public string $bin, public PriceData $price)
    {
    }

    public static function fromArray(array $data): TransactionData
    {
        return new TransactionData($data['bin'], new PriceData((float)$data['amount'], $data['currency']));
    }
}