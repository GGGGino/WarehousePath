<?php

use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Warehouse;
use PHPUnit\Framework\TestCase;

final class WarehouseTest extends TestCase
{
    public function testTransformToTreeConstructor(): void
    {
        /** @var Warehouse $testMatrix */
        $testMatrix = Warehouse::createFromJson(getcwd() . "/resources/simpleWarehouse.json");

        $calculatedArray = $testMatrix->getPlaces();

        /** @var Place $nodeStart */
        $nodeStart = $calculatedArray[4];
        /** @var Place $nodeEnd */
        $nodeEnd = $calculatedArray[20];

        $this->assertEquals('04', $nodeStart->getName());
        $this->assertEquals('26', $nodeEnd->getName());
        $testMatrix->getPath($nodeStart, $nodeEnd);
    }
}