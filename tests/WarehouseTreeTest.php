<?php

use GGGGino\WarehousePath\Entity\Corridor;
use GGGGino\WarehousePath\Entity\Location;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Entity\Wall;
use GGGGino\WarehousePath\Warehouse;
use GGGGino\WarehousePath\WarehouseTree;
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
     *  L1|W1|L6
     *  L2|W2|L5
     *  L3|C1|L4
     */
    protected function setUp()
    {
        $loc1 = new Location('L1');
        $loc2 = new Location('L2');
        $loc3 = new Location('L3');
        $loc4 = new Location('L4');
        $loc5 = new Location('L5');
        $loc6 = new Location('L6');
        $loc7 = new Location('L7');
        $loc8 = new Location('L8');
        $corr1 = new Corridor('C1');
        $wall1 = new Wall('W1');
        $wall2 = new Wall('W2');

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

        $this->warehouse = Warehouse::createFromTree($arrayPlaces);
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
        $start = $this->warehouse->getPlaces()[0];
        /** @var Place $end */
        $end = $this->warehouse->getPlaces()[4];

        $this->warehouse->getPath($start, $end);
        $this->assertEquals(7, $end->getCurrentWeight());
    }

    public function testPath2(): void
    {
        /** @var Place $start */
        $start = $this->warehouse->getPlaces()[0];
        /** @var Place $end */
        $end = $this->warehouse->getPlaces()[6];

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