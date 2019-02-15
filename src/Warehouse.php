<?php

namespace GGGGino\WarehousePath;

use GGGGino\WarehousePath\Calculator\CalculatorInterface;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Parser\JsonMatrixParser;
use GGGGino\WarehousePath\Parser\MatrixParser;
use GGGGino\WarehousePath\Parser\ParserInterface;

class Warehouse
{
    /**
     * @var PlacesCollector
     */
    private $placesCollector;

    /**
     * @var Place[]
     */
    private $places = array();

    /**
     * @var CalculatorInterface
     */
    private $pathCalculator;

    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(PlacesCollector $placesCollector, ParserInterface $parser)
    {
        $this->placesCollector = $placesCollector;
        $this->parser = $parser;
    }

    /***
     * @param array $param
     * @return WarehouseMatrix
     * @throws \Exception
     * @deprecated
     */
    public static function createMatrix($param)
    {
        if( !is_array($param) )
            throw new \Exception('Matrix should be initialized with an array');

        $placesCollector = new PlacesCollector();
        $placesCollector->addBasePlaceTypes();

        $wm = new WarehouseMatrix($placesCollector);
        $wm->createByMatrix($param);

        return $wm;
    }

    /***
     * @param string $path
     * @return Warehouse
     * @throws \Exception
     */
    public static function createFromJson($path)
    {
        if( !$path )
            throw new \Exception('Please select a path');

        $placesCollector = new PlacesCollector();
        $placesCollector->addBasePlaceTypes();

        $wm = new JsonMatrixParser($path, $placesCollector);

        $instance = new self($placesCollector, $wm);
        $instance->setPlaces($wm->parse());

        return $instance;
    }

    /**
     * @param $param
     * @return Warehouse
     * @throws \Exception
     */
    public static function createFromMatrix($param)
    {
        if( !is_array($param) )
            throw new \Exception('Matrix should be initialized with an array');

        $placesCollector = new PlacesCollector();
        $placesCollector->addBasePlaceTypes();

        $wm = new MatrixParser($param, $placesCollector);

        $instance = new self($placesCollector, $wm);
        $instance->setPlaces($wm->parse());

        return $instance;
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
     * @param $arrayNodes
     * @param $matrix
     * @return Place[]
     */
    public function calculate($arrayNodes, $matrix)
    {
        return $this->pathCalculator->calculate($arrayNodes, $matrix);
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
     * @return Warehouse
     */
    public function setPlaces($places)
    {
        $this->places = $places;
        return $this;
    }

    /**
     * @param CalculatorInterface $pathCalculator
     * @return Warehouse
     */
    public function setPathCalculator($pathCalculator)
    {
        $this->pathCalculator = $pathCalculator;
        return $this;
    }

    /**
     * @param PlacesCollector $placesCollector
     * @return Warehouse
     */
    public function setPlacesCollector($placesCollector)
    {
        $this->placesCollector = $placesCollector;
        return $this;
    }

    /**
     * @return ParserInterface
     */
    public function getParser(): ParserInterface
    {
        return $this->parser;
    }
}