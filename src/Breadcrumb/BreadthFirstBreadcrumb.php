<?php

namespace GGGGino\WarehousePath\Breadcrumb;

use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\PlacesCollector;

class BreadthFirstBreadcrumb implements BreadcrumbInterface
{
    /**
     * Callback useful if you want to modifiy temporarily some wharehouse configuration
     * es.
     * function(Place $startPlace, array $placesType) {};
     *
     * @var callable|null
     */
    private $onPreCreateBreadcumb = null;

    /**
     * Callback useful if you want to customize the mapping of this wharehouse.
     * Called in every loops
     * es.
     * function(Place $currentPlace) {};
     *
     * @var callable|null
     */
    private $onWalk = null;

    /**
     * @var PlacesCollector
     */
    protected $placeCollector;

    /**
     * BreadthFirstBreadcrumb constructor.
     * @param PlacesCollector $placeCollector
     */
    public function __construct(PlacesCollector $placeCollector)
    {
        $this->placeCollector = $placeCollector;
    }

    /**
     * Main algorithm to find the shortest path.
     *
     * @todo: nel futuro quando ci sarà un magazzino grande, spezzare il magazzino prendendo solo il quadrato contenente i vari punti
     *
     * @param Place $startPlace
     * @param Place $endPlace if not null do early exit
     */
    public function createBreadcrumb(Place $startPlace, Place $endPlace = null)
    {
        if ( is_callable( $this->onPreCreateBreadcumb ) ) {
            call_user_func($this->onPreCreateBreadcumb, $startPlace, $this->placeCollector->getPlacesType());
        }

        $frontier = array();
        array_push($frontier, $startPlace);

        while (!empty($frontier)) {
            /** @var Place $current */
            $current = array_shift($frontier);

            if ( is_callable( $this->onWalk ) ) {
                call_user_func($this->onWalk, $current);
            }

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

    /**
     * @param callable|null $onPreCreateBreadcumb
     * @return BreadthFirstBreadcrumb
     */
    public function setOnPreCreateBreadcumb($onPreCreateBreadcumb)
    {
        $this->onPreCreateBreadcumb = $onPreCreateBreadcumb;
        return $this;
    }

    /**
     * @param callable|null $onWalk
     * @return BreadthFirstBreadcrumb
     */
    public function setOnWalk($onWalk)
    {
        $this->onWalk = $onWalk;
        return $this;
    }
}