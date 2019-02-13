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
     * Main algorithm to find the shortest path.
     *
     * @todo: nel futuro quando ci sarà un magazzino grande, spezzare il magazzino prendendo solo il quadrato contenente i vari punti
     *
     * @param Place $startPlace
     * @param Place $endPlace
     */
    public function getPath(Place $startPlace, Place $endPlace)
    {
        $frontier = array();
        array_push($frontier, $startPlace);

        while (!empty($frontier)) {
            /** @var Place $current */
            $current = array_shift($frontier);

            /** @var Place $vicino */
            foreach ($current->getNeighbors() as $vicino ) {
                if( !$vicino )
                    continue;

                $tempCost = $current->getCurrentWeight() + $vicino->getOriginalWeight();

                if( $vicino->isVisited() && $tempCost < $vicino->getCurrentWeight() ) {
                    //echo "Ripasso: " . $current->getName() . "->" . $vicino->getName() . " new: " . $tempCost . " old: " . $vicino->getCurrentWeight() . "\n\r";
                    $vicino->setCurrentWeight($tempCost);
                    $vicino->setWalkingCameFrom($current);
                    array_push($frontier, $vicino);
                }

                if( $vicino->isVisited() )
                    continue;

                $vicino->setVisited(true);

                $vicino->increaseCurrentWeight($current->getCurrentWeight());
                $vicino->setWalkingCameFrom($current);

                //echo $current->getName() . "->" . $vicino->getName() . ": " . $vicino->getCurrentWeight() . "\n\r";

                array_push($frontier, $vicino);
            }

            $current->setVisited(true);
        }
    }

    /**
     * @return Place[]
     */
    public function getPlaces(): array
    {
        return $this->places;
    }

    /**
     * @param Entity\Place[] $places
     * @return WarehouseTree
     */
    public function setPlaces($places)
    {
        $this->places = $places;
        return $this;
    }
}