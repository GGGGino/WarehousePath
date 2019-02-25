<?php

namespace GGGGino\WarehousePath\Parser;

use GGGGino\WarehousePath\PlacesCollector;

class TreeParser implements ParserInterface
{
    /**
     * @var array
     */
    private $places;
    /**
     * @var PlacesCollector
     */
    private $placeCollector;

    public function __construct(array $places, PlacesCollector $placeCollector)
    {
        $this->places = $places;
        $this->placeCollector = $placeCollector;
    }

    /**
     * @return mixed
     */
    public function parse()
    {
        $this->placeCollector->setPlaces($this->places);
        return $this->places;
    }
}