<?php

use GGGGino\WarehousePath\Breadcrumb\FastBreadthFirstBreadcrumb;
use GGGGino\WarehousePath\Calculator\FastCalculator;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Parser\JsonMatrixParser;
use GGGGino\WarehousePath\PlacesCollector;
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

        $calculatedArray = $testMatrix->getPlacesCollector()->getPlaces();

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

        $calculatedArray = $testMatrix->getPlacesCollector()->getPlaces();

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
    public function testBigMultiplePath(): void
    {
        /** @var Warehouse $testMatrix */
        $testMatrix = Warehouse::createFromJson(getcwd() . "/resources/biggerWarehouse.json");

        $calculatedArray = $testMatrix->getPlacesCollector()->getPlaces();

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

    /**
     *
     */
    public function testBigFastMultiplePath(): void
    {
        $path = getcwd() . "/resources/biggerWarehouse.json";
        $placesCollector = new PlacesCollector();
        $placesCollector->addBasePlaceTypes();

        $breadcrumbBuilder = new FastBreadthFirstBreadcrumb($placesCollector);

        $wm = new JsonMatrixParser($path, $placesCollector);

        $wh = new Warehouse($placesCollector, $wm, $breadcrumbBuilder);
        $wh->getPlacesCollector()->setPlaces($wm->parse());

        $calculatedArray = $wh->getPlacesCollector()->getPlaces();

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

        $matrix = $wh->getMultiplePath($nodes);
        $this->assertEquals(12, count($matrix));

        $wh->setPathCalculator(new FastCalculator());

        $arrayOrdered = $wh->calculate($nodes, $matrix);
        $this->assertEquals(12, count($arrayOrdered));
    }
}