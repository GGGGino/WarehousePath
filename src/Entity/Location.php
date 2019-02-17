<?php

namespace GGGGino\WarehousePath\Entity;

/**
 * Class Location
 * @package GGGGino\WarehousePath\Entity
 */
class Location extends Place
{
    /**
     * @inheritdoc
     */
    public function __construct($name = "")
    {
        $this->originalWeight = 1;

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