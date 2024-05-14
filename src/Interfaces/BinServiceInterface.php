<?php

namespace Shota\TaskRefactorCode\Interfaces;

use Shota\TaskRefactorCode\Data\BinData;

interface BinServiceInterface
{
    public function getBinData(string $bin): BinData;
}