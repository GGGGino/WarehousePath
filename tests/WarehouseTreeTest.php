<?php

use GGGGino\WarehousePath\Entity\Corridor;
use GGGGino\WarehousePath\Entity\Location;
use GGGGino\WarehousePath\Entity\Wall;
use GGGGino\WarehousePath\WarehouseTree;
use PHPUnit\Framework\TestCase;

final class WarehouseTreeTest extends TestCase
{
    protected $wt;

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
        $loc1 = new Location();
        $loc2 = new Location();
        $loc3 = new Location();
        $loc4 = new Location();
        $loc5 = new Location();
        $loc6 = new Location();
        $corr1 = new Corridor();
        $wall1 = new Wall();
        $wall2 = new Wall();

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
        $loc5->setBottomRef($loc4);

        $this->wt = new WarehouseTree(array($loc1, $loc2, $loc3, $loc4, $loc5));
    }

    /**
     * Test instance
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(WarehouseTree::class, $this->wt);
    }

    public function testPlaces(): void
    {
        $this->assertInstanceOf(WarehouseTree::class, $this->wt);
    }
}