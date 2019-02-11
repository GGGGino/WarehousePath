<?php

namespace GGGGino\WarehousePath\Entity;

class Location extends Place
{
    public function __construct()
    {
        $this->weight = 1;
    }
}