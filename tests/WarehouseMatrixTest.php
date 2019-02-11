<?php

use GGGGino\WarehousePath\WarehouseMatrix;
use PHPUnit\Framework\TestCase;

final class WarehouseMatrixTest extends TestCase
{
    public function testWarehouseConstructor(): void
    {
        $test1 = WarehouseMatrix::createFromDimension(1, 5);

        $this->assertInstanceOf(WarehouseMatrix::class, $test1);

        $test2 = WarehouseMatrix::createFromMatrix(array('pluto'));

        $this->assertInstanceOf(WarehouseMatrix::class, $test2);
    }
}