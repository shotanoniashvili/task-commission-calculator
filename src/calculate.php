<?php

use Shota\TaskRefactorCode\Data\TransactionData;

require 'vendor/autoload.php';

try {
    $handle = fopen($argv[1], 'r');
} catch (Exception $e) {
    throw new Exception('Invalid file path.');
}

while (($line = fgets($handle)) !== false) {
    if (empty($line)) {
        break;
    }

    $transaction = TransactionData::fromArray(json_decode($line, true));

    $binData = bin()->getBinData($transaction->bin);

    $commission = is_eu_country($binData->country->code)
        ? calculation()->calculateForEuCountry($transaction->price)
        : calculation()->calculateForNonEuCountry($transaction->price);

    print $commission->amount . PHP_EOL;
}

fclose($handle);
