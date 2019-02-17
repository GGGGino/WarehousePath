<?php

namespace GGGGino\WarehousePath\Entity;

/**
 * Class Wall
 * @package GGGGino\WarehousePath\Entity
 */
class Wall extends Place
{
    /**
     * @inheritdoc
     */
    public function __construct($name = "")
    {
        $this->originalWeight = 100;

        parent::__construct($name);
    }

    /**
     * Describe if the place will be walkable or not
     *
     * @return boolean
     */
    public function isWalkable()
    {
        return false;
    }
}