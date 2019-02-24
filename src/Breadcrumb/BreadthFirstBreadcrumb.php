<?php

namespace GGGGino\WarehousePath\Breadcrumb;

use GGGGino\WarehousePath\Entity\Place;

class BreadthFirstBreadcrumb implements BreadcrumbInterface
{
    /**
     * Main algorithm to find the shortest path.
     *
     * @todo: nel futuro quando ci sarà un magazzino grande, spezzare il magazzino prendendo solo il quadrato contenente i vari punti
     * @todo: permettere la modifica al volo del peso delle locazioni
     *
     * @param Place $startPlace
     * @param Place $endPlace if not null do early exit
     */
    public function createBreadcrumb(Place $startPlace, Place $endPlace = null)
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
                    continue;
                }

                if ($vicino->isVisited()) {
                    continue;
                }

                $vicino->setVisited(true);

                $vicino->increaseCurrentWeight($current->getCurrentWeight());
                $vicino->setWalkingCameFrom($current);

                array_push($frontier, $vicino);
            }

            $current->setVisited(true);
        }
    }
}