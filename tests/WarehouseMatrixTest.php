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

    public function testWarehouse(): void
    {
        $testMatrix = array(
            array(   2,   1, 100,   1,   2,   1),
            array(   2,   1, 100,   1,   2,   1),
            array(   2,   1, 100,   1,   2,   1),
            array(   2,   2,   2,   2,   2,   1)
        );

        $test2 = WarehouseMatrix::createFromMatrix($testMatrix);

        $this->assertInstanceOf(WarehouseMatrix::class, $test2);
    }
}