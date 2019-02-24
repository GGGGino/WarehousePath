<?php

namespace GGGGino\WarehousePath\Entity;

abstract class PlaceType
{
    /**
     * An identifier to recognize the node
     *
     * @var string
     */
    protected $name;

    /**
     * Original Weight given on instantiation
     *
     * @var int
     */
    protected $originalWeight = 0;

    /**
     * Place constructor.
     * @param string $name
     */
    public function __construct($name = "")
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->getOriginalWeight();
    }

    /**
     * Describe if the place will be walkable or not
     *
     * @return boolean
     */
    abstract public function isWalkable();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PlaceType
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getOriginalWeight()
    {
        return $this->originalWeight;
    }
}