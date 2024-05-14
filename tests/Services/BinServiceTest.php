<?php

namespace tests\Services;

use PHPUnit\Framework\TestCase;
use Shota\TaskRefactorCode\Data\BinData;
use Shota\TaskRefactorCode\Services\BinListService\BinListService;

class BinServiceTest extends TestCase
{
    protected BinListService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = bin();
    }

    public function testGetBinData(): void
    {
        $fakeBin = '45717360';

        $binData = $this->service->getBinData($fakeBin);

        $this->assertInstanceOf(BinData::class, $binData);
    }
}