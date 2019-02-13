<?php

use GGGGino\WarehousePath\Warehouse;
use GGGGino\WarehousePath\WarehouseMatrix;
use GGGGino\WarehousePath\WarehouseTree;
use PHPUnit\Framework\TestCase;

final class WarehouseMatrixTest extends TestCase
{
    /**
     * Super simple warehouse representation
     *
     * @return array
     */
    public static function getMatrixSimple()
    {
        return array(
            array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
            array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
            array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
            array(array('weight' => 2), array('weight' => 2), array('weight' =>   2), array('weight' => 2), array('weight' => 2), array('weight' => 1))
        );
    }

    public function testWarehouseConstructor(): void
    {
        $testMatrix = Warehouse::createMatrix(self::getMatrixSimple());

        $this->assertInstanceOf(WarehouseMatrix::class, $testMatrix);
    }
}