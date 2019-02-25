<?php

use GGGGino\WarehousePath\Breadcrumb\BreadthFirstBreadcrumb;
use GGGGino\WarehousePath\Entity\Corridor;
use GGGGino\WarehousePath\Entity\Location;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Entity\Wall;
use GGGGino\WarehousePath\Parser\TreeParser;
use GGGGino\WarehousePath\PlacesCollector;
use GGGGino\WarehousePath\Warehouse;
use PHPUnit\Framework\TestCase;

final class WarehouseTreeTest extends TestCase
{
    /**
     * @var Warehouse
     */
    protected $warehouse;

    /**
     * Simple warehouse structure
     * Lx = Location
     * Wx = Wall
     * Cx = Corridor
     *
     *  L1|W1|L6|L7
     *  L2|W2|L5|L8
     *  L3|C1|L4
     */
    protected function setUp()
    {
        $placesCollector = new PlacesCollector();
        $placesCollector->addBasePlaceTypes();

        /** @var Location $locationType */
        $locationType = $placesCollector->getPlaceTypeByClass(Location::class);
        /** @var Corridor $locationType */
        $corridorType = $placesCollector->getPlaceTypeByClass(Corridor::class);
        /** @var Wall $locationType */
        $wallType = $placesCollector->getPlaceTypeByClass(Wall::class);

        $loc1 = new Place($locationType, 'L1');
        $loc2 = new Place($locationType, 'L2');
        $loc3 = new Place($locationType, 'L3');
        $loc4 = new Place($locationType, 'L4');
        $loc5 = new Place($locationType, 'L5');
        $loc6 = new Place($locationType, 'L6');
        $loc7 = new Place($locationType, 'L7');
        $loc8 = new Place($locationType, 'L8');
        $corr1 = new Place($corridorType, 'C1');
        $wall1 = new Place($wallType, 'W1');
        $wall2 = new Place($wallType, 'W2');

        $loc1->setRightRef($wall1);
        $loc1->setBottomRef($loc2);

        $loc2->setRightRef($wall2);
        $loc2->setBottomRef($loc3);

        $loc3->setRightRef($corr1);

        $wall1->setBottomRef($wall2);
        $wall1->setRightRef($loc6);

        $wall2->setBottomRef($corr1);
        $wall2->setRightRef($loc5);

        $corr1->setRightRef($loc4);
        $loc6->setBottomRef($loc5);
        $loc6->setRightRef($loc7);
        $loc5->setBottomRef($loc4);
        $loc5->setRightRef($loc8);

        $loc7->setBottomRef($loc8);

        $arrayPlaces = array($loc1, $loc2, $loc3, $loc4, $loc5, $loc6, $loc7, $loc8, $corr1, $wall1, $wall2);

        $wm = new TreeParser($arrayPlaces, $placesCollector);
        $placesCollector->setPlaces($wm->parse());

        $breadcrumbBuilder = new BreadthFirstBreadcrumb($placesCollector);

        $this->warehouse = new Warehouse($placesCollector, $wm, $breadcrumbBuilder);
    }

    /**
     * Test instance
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(Warehouse::class, $this->warehouse);
    }

    public function testPath(): void
    {
        /** @var Place $start */
        $start = $this->warehouse->getPlacesCollector()->getPlaces()[0];
        /** @var Place $end */
        $end = $this->warehouse->getPlacesCollector()->getPlaces()[4];

        $this->warehouse->getPath($start, $end);
        $this->assertEquals(7, $end->getCurrentWeight());
    }

    public function testPath2(): void
    {
        /** @var Place $start */
        $start = $this->warehouse->getPlacesCollector()->getPlaces()[0];
        /** @var Place $end */
        $end = $this->warehouse->getPlacesCollector()->getPlaces()[6];

        $this->warehouse->getPath($start, $end);
        $this->assertEquals(9, $end->getCurrentWeight());
    }

    public function testPrintMatrix(): void
    {
        /** @var Place[][] $matrix */
        $matrix = $this->warehouse->createMatrix();
        $this->assertEquals(3, count($matrix));
        $this->assertEquals(4, count($matrix[0]));
    }
}