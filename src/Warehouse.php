<?php

namespace GGGGino\WarehousePath;

use GGGGino\WarehousePath\Breadcrumb\BreadcrumbInterface;
use GGGGino\WarehousePath\Breadcrumb\BreadthFirstBreadcrumb;
use GGGGino\WarehousePath\Calculator\CalculatorInterface;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Parser\JsonMatrixParser;
use GGGGino\WarehousePath\Parser\MatrixParser;
use GGGGino\WarehousePath\Parser\ParserInterface;
use GGGGino\WarehousePath\Parser\TreeParser;

class Warehouse
{
    /**
     * @var PlacesCollector
     */
    private $placesCollector;

    /**
     * @var CalculatorInterface
     */
    private $pathCalculator;

    /**
     * @var ParserInterface
     */
    private $parser;
    /**
     * @var BreadcrumbInterface
     */
    private $breadcrumbBuilder;

    public function __construct(PlacesCollector $placesCollector, ParserInterface $parser, BreadcrumbInterface $breadcrumbBuilder)
    {
        $this->placesCollector = $placesCollector;
        $this->parser = $parser;
        $this->breadcrumbBuilder = $breadcrumbBuilder;
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

        $breadcrumbBuilder = new BreadthFirstBreadcrumb($placesCollector);

        $wm = new JsonMatrixParser($path, $placesCollector);
        $placesCollector->setPlaces($wm->parse());

        $instance = new self($placesCollector, $wm, $breadcrumbBuilder);

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

        $breadcrumbBuilder = new BreadthFirstBreadcrumb($placesCollector);

        $wm = new MatrixParser($param, $placesCollector);
        $placesCollector->setPlaces($wm->parse());

        $instance = new self($placesCollector, $wm, $breadcrumbBuilder);

        return $instance;
    }

    /**
     * @param $param
     * @return Warehouse
     * @throws \Exception
     */
    public static function createFromTree($param)
    {
        if( !is_array($param) )
            throw new \Exception('Should be initialized with an array');

        $placesCollector = new PlacesCollector();
        $placesCollector->addBasePlaceTypes();

        $breadcrumbBuilder = new BreadthFirstBreadcrumb($placesCollector);

        $wm = new TreeParser($param, $placesCollector);
        $placesCollector->setPlaces($wm->parse());

        $instance = new self($placesCollector, $wm, $breadcrumbBuilder);

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
        $this->breadcrumbBuilder->createBreadcrumb($startPlace, $endPlace);
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
     * For every place i create the path
     *
     * @param Place[] $places
     * @return array
     */
    public function getMultiplePath(array $places)
    {
        return $this->breadcrumbBuilder->createMultipleBreadcrumb($places);
    }

    /**
     * Create the matrix for development purpose.
     * If you want to print the whole wharehouse
     *
     * @return Entity\Place[][]
     * @throws \Exception
     */
    public function createMatrix()
    {
        /** @var Place[] $places */
        $places = $this->getPlaces();

        /** @var Place[][] $resultMatrix */
        $resultMatrix = array();

        if ( empty($places) )
            throw new \Exception('First add the places');

        /** @var Place $startingPlace */
        $startingPlace = reset($places);

        while ( $newPlace = $startingPlace->getTopRef() ) {
            $startingPlace = $newPlace;
        }

        while ( $newPlace = $startingPlace->getLeftRef() ) {
            $startingPlace = $newPlace;
        }

        /** @var Place $rowPlace */
        $rowPlace = $startingPlace;

        do {
            $tempRow = array();

            /** @var Place $columnPlace */
            $columnPlace = $rowPlace;

            do {
                $tempRow[] = $columnPlace;
            } while ($columnPlace = $columnPlace->getRightRef());

            $resultMatrix[] = $tempRow;
        } while ($rowPlace = $rowPlace->getBottomRef());

        return $resultMatrix;
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

    /**
     * @return PlacesCollector
     */
    public function getPlacesCollector()
    {
        return $this->placesCollector;
    }
}