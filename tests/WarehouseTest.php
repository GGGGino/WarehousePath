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
    public function testTransformToTreeConstructor(): void
    {
        $testMatrix = Warehouse::createFromJson(getcwd() . "/resources/simpleWarehouse.json");

        $calculatedArray = $testMatrix->getPlaces();

        $wt = new WarehouseTree($calculatedArray);

        /** @var Place $nodeStart */
        $nodeStart = $calculatedArray[4];
        /** @var Place $nodeEnd */
        $nodeEnd = $calculatedArray[20];

        $this->assertEquals('04', $nodeStart->getName());
        $this->assertEquals('26', $nodeEnd->getName());
        $wt->getPath($nodeStart, $nodeEnd);
    }
}