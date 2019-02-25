<?php

use GGGGino\WarehousePath\Calculator\FastCalculator;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Warehouse;
use PHPUnit\Framework\TestCase;

final class WarehouseTest extends TestCase
{
    /**
     *
     */
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

    /**
     *
     */
    public function testBigConstructor(): void
    {
        /** @var Warehouse $testMatrix */
        $testMatrix = Warehouse::createFromJson(getcwd() . "/resources/biggerWarehouse.json");

        $calculatedArray = $testMatrix->getPlaces();

        /** @var Place $nodeStart */
        $nodeStart = $calculatedArray[4];
        /** @var Place $nodeEnd */
        $nodeEnd = $calculatedArray[20];

        $this->assertEquals('04', $nodeStart->getName());
        $this->assertEquals('22', $nodeEnd->getName());
        $testMatrix->getPath($nodeStart, $nodeEnd);
    }

    /**
     *
     */
    public function testBigConstructorMultiplePath(): void
    {
        /** @var Warehouse $testMatrix */
        $testMatrix = Warehouse::createFromJson(getcwd() . "/resources/biggerWarehouse.json");

        $calculatedArray = $testMatrix->getPlaces();

        /** @var Place[] $nodes */
        $nodes = array(
            $calculatedArray[4],
            $calculatedArray[20],
            $calculatedArray[48],
            $calculatedArray[62],
            $calculatedArray[10],
            $calculatedArray[49],
            $calculatedArray[14],
            $calculatedArray[100],
            $calculatedArray[120],
            $calculatedArray[122],
            $calculatedArray[60],
            $calculatedArray[15]
        );

        $matrix = $testMatrix->getMultiplePath($nodes);
        $this->assertEquals(12, count($matrix));

        $testMatrix->setPathCalculator(new FastCalculator());

        $arrayOrdered = $testMatrix->calculate($nodes, $matrix);
        $this->assertEquals(12, count($arrayOrdered));
    }
}