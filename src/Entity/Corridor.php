<?php

namespace GGGGino\WarehousePath\Entity;

class Corridor extends Place
{
    public function __construct($name = "")
    {
        $this->originalWeight = 2;

        parent::__construct($name);
    }

    /**
     * Describe if the place will be walkable or not
     *
     * @return boolean
     */
    public function isWalkable()
    {
        return true;
    }
}