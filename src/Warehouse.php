<?php

namespace GGGGino\WarehousePath;

class Warehouse
{
    public static function create($param)
    {
        if( is_array($param) ) {
            new WarehouseMatrix($param);
        }
    }
}