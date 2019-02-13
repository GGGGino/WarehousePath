<?php

namespace GGGGino\WarehousePath;

class Warehouse
{
    /**
     * @var PlacesCollector
     */
    private $placesCollector;

    public static function create($param)
    {
        if( is_array($param) ) {
            new WarehouseMatrix($param);
        }
    }

    /***
     * @param array $param
     * @return WarehouseMatrix
     * @throws \Exception
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
}