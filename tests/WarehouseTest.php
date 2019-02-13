<?php

use GGGGino\WarehousePath\Entity\Corridor;
use GGGGino\WarehousePath\Entity\Location;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Entity\Wall;
use GGGGino\WarehousePath\Warehouse;
use GGGGino\WarehousePath\WarehouseTree;
use PHPUnit\Framework\TestCase;

final class WarehouseTest extends TestCase
{
    private function printMatrix($array)
    {
        echo "\n\r";
        foreach($array as $rKey => $row) {
            foreach($row as $cKey => $column) {
                echo str_pad($column->getName() . "-" . $column->getOriginalWeight(), 10) ;
            }
            echo "\n\r";
        }
    }

    public function testTransformToTreeConstructor(): void
    {
        $testMatrix = Warehouse::createMatrix(WarehouseMatrixTest::getMatrixSimple());

        $calculatedArray = $testMatrix->getCalculatedArray();
        $calculatedMatrix = $testMatrix->getCalculatedMatrix();

        $wt = new WarehouseTree($calculatedArray);

        /** @var Place $nodeStart */
        $nodeStart = $calculatedArray[4];
        /** @var Place $nodeEnd */
        $nodeEnd = $calculatedArray[20];

        $this->assertEquals('04', $nodeStart->getName());
        $this->assertEquals('32', $nodeEnd->getName());
        $wt->getPath($nodeStart, $nodeEnd);

        $this->printMatrix($calculatedMatrix);
        while( $nodeEnd ) {
            echo "\n\r" . $nodeEnd->getName();
            $nodeEnd = $nodeEnd->getWalkingCameFrom();
        }
        die();
    }
}