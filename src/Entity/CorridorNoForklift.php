<?php

namespace GGGGino\WarehousePath\Entity;

/**
 * No very used but will be useful or future development.
 * Now Used for tosting
 *
 * Class CorridorNoForklift
 * @package GGGGino\WarehousePath\Entity
 */
class CorridorNoForklift extends PlaceType
{
    /**
     * @inheritdoc
     */
    public function __construct($name = "")
    {
        $this->originalWeight = 5;

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