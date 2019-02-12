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
        $frontier = array();
        array_push($frontier, $startPlace);

        echo "\n\r";

        while (!empty($frontier)) {
            /** @var Place $current */
            $current = array_shift($frontier);

            if( $current->isVisited() )
                continue;

            $current->setVisited(true);

            $walkableNeighbors = $current->getWalkableNeighbors();

            if( count($walkableNeighbors) == 0 )
                continue;

            /** @var Place $vicino */
            foreach ($current->getWalkableNeighbors() as $vicino ) {

                $vicino->increaseCurrentWeight($current->getCurrentWeight());
                $vicino->setWalkingCameFrom($current);

                echo $current->getName() . "->" . $vicino->getName() . ": " . $vicino->getCurrentWeight() . "\n\r";
                /*if( $vicino === $endPlace ){
                    die('win: ' . $vicino->getName() . " with " . $vicino->getCurrentWeight());
                }*/

                array_push($frontier, $vicino);
            }

            $current->setVisited(true);
        }
    }
}