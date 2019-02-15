<?php

namespace GGGGino\WarehousePath\Parser;

use GGGGino\WarehousePath\PlacesCollector;

class TreeParser implements ParserInterface
{
    /**
     * @var array
     */
    private $places;

    public function __construct(array $places)
    {
        $this->places = $places;
    }

    /**
     * @return mixed
     */
    public function parse()
    {
        return $this->places;
    }
}