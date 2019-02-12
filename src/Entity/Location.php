<?php

namespace GGGGino\WarehousePath\Entity;

class Location extends Place
{
    public function __construct($name = "")
    {
        $this->originalWeight = 1;

        parent::__construct($name);
    }
}