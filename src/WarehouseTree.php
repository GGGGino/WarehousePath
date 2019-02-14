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
     * @param Place $endPlace if not null do early exit
     */
    public function getPath(Place $startPlace, Place $endPlace = null)
    {
        $frontier = array();
        array_push($frontier, $startPlace);

        while (!empty($frontier)) {
            /** @var Place $current */
            $current = array_shift($frontier);

            /** @var Place $vicino */
            foreach ($current->getWalkableNeighbors() as $vicino) {
                $tempCost = $current->getCurrentWeight() + $vicino->getOriginalWeight();

                if ($vicino->isVisited() && $tempCost < $vicino->getCurrentWeight()) {
                    $vicino->setCurrentWeight($tempCost);
                    $vicino->setWalkingCameFrom($current);
                    array_push($frontier, $vicino);
                }

                if ($vicino->isVisited())
                    continue;

                $vicino->setVisited(true);

                $vicino->increaseCurrentWeight($current->getCurrentWeight());
                $vicino->setWalkingCameFrom($current);

                array_push($frontier, $vicino);
            }

            $current->setVisited(true);
        }
    }

    /**
     * Reset all the node to permit another calculation
     */
    public function reset()
    {
        foreach ($this->places as $place) {
            $place->reset();
        }
    }

    /**
     * @param Place[] $places
     * @return array
     */
    public function getMultiplePath(array $places)
    {
        $matrixDistances = array();

        /** @var Place $place */
        foreach ($places as $place) {
            $this->getPath($place);
            $tempPlaceDistance = array();

            /** @var Place $place */
            foreach ($places as $place1) {
                $tempPlaceDistance[] = $place1->getCurrentWeight();
            }

            $matrixDistances[] = $tempPlaceDistance;
            $this->reset();
        }

        return $matrixDistances;
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