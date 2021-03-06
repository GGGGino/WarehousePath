<?php

namespace GGGGino\WarehousePath;

use GGGGino\WarehousePath\Entity\Corridor;
use GGGGino\WarehousePath\Entity\Location;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Entity\PlaceType;
use GGGGino\WarehousePath\Entity\Wall;

/**
 * Class PlacesCollector
 * @package GGGGino\WarehousePath
 */
class PlacesCollector
{
    /**
     * @var PlaceType[]
     */
    private $placeTypes;

    /**
     * @var Place[]
     */
    private $places = array();

    public function __construct()
    {
        $this->placeTypes = array();
        $this->places = array();
    }

    /**
     * @return PlaceType[]
     */
    public function getPlacesType()
    {
        return $this->placeTypes;
    }

    /**
     * @param PlaceType[] $placeTypes
     * @return PlacesCollector
     */
    public function setPlacesType($placeTypes)
    {
        $this->placeTypes = $placeTypes;
        return $this;
    }

    /**
     * @param $placeType
     * @return $this
     */
    public function addPlaceType($placeType)
    {
        $this->placeTypes[] = $placeType;
        return $this;
    }

    /**
     * @return $this
     */
    public function addBasePlaceTypes()
    {
        $this->addPlaceType(new Location());
        $this->addPlaceType(new Corridor());
        $this->addPlaceType(new Wall());

        return $this;
    }

    /**
     * Get the placeType from a give classname
     *
     * @param $class
     * @return Place
     */
    public function &getPlaceTypeByClass($class)
    {
        /** @var Place $placeType */
        foreach ($this->placeTypes as $placeType) {
            if ($placeType instanceof $class) {
                return $placeType;
            }
        }

        return null;
    }

    /**
     * @param $weight
     * @return Place
     */
    public function &getPlaceTypeByWeight($weight)
    {
        /** @var Place $placeType */
        foreach ($this->placeTypes as $placeType) {
            if ($weight == $placeType->getOriginalWeight()) {
                return $placeType;
            }
        }

        return null;
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
     * @return Place[]
     */
    public function getPlaces(): array
    {
        return $this->places;
    }

    /**
     * @param Place[] $places
     * @return PlacesCollector
     */
    public function setPlaces($places)
    {
        $this->places = $places;
        return $this;
    }
}