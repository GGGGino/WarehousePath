<?php

use GGGGino\WarehousePath\Entity\Corridor;
use GGGGino\WarehousePath\Entity\CorridorNoForklift;
use GGGGino\WarehousePath\PlacesCollector;
use GGGGino\WarehousePath\Warehouse;
use PHPUnit\Framework\TestCase;

final class PlaceCollectorTest extends TestCase
{
    public function testGetTotalPlaces(): void
    {
        /** @var PlacesCollector $placeCollector */
        $placeCollector = new PlacesCollector();

        $placeCollector->addBasePlaceTypes();

        $this->assertEquals(3, count($placeCollector->getPlacesType()));
    }

    public function testGetByWeight(): void
    {
        /** @var PlacesCollector $placeCollector */
        $placeCollector = new PlacesCollector();

        $placeCollector->addBasePlaceTypes();

        $this->assertInstanceOf(Corridor::class, $placeCollector->getPlaceTypeByWeight(2));
    }

    public function testAddAndGetByWeight(): void
    {
        /** @var PlacesCollector $placeCollector */
        $placeCollector = new PlacesCollector();

        $placeCollector->addBasePlaceTypes();

        $placeCollector->addPlaceType(new CorridorNoForklift());

        $this->assertInstanceOf(CorridorNoForklift::class, $placeCollector->getPlaceTypeByWeight(5));
    }
}