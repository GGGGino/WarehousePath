<?php

namespace GGGGino\WarehousePath;

use GGGGino\WarehousePath\Entity\Place;

class WarehouseTree
{
    /**
     * @var Place[]
     */
    private $places = array();

    public function __construct($places)
    {
        $this->places = $places;
    }

    /**
     * @return Place[]
     */
    public function getPlaces(): array
    {
        return $this->places;
    }

    /**
     * @param Place $startPlace
     * @param Place $endPlace
     */
    public function getPath(Place $startPlace, Place $endPlace)
    {
        $startPlace->setVisited(true);
        $current = &$startPlace;
        $weight = 0;

        while(true) {
            /** @var Place $vicino */
            foreach ($current->getNeighbors() as $vicino ) {
                if( $vicino->isVisited() )
                    continue;

                if( $vicino === $endPlace )
                    die('win');

                $current = &$vicino;
            }
        }
    }
}