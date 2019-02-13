<?php

namespace GGGGino\WarehousePath\Entity;

abstract class Place
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Place
     */
    protected $leftRef = null;

    /**
     * @var Place
     */
    protected $rightRef = null;

    /**
     * @var Place
     */
    protected $topRef = null;

    /**
     * @var Place
     */
    protected $bottomRef = null;

    /**
     * @var Place
     */
    protected $walkingCameFrom = null;

    /**
     * @var bool
     */
    protected $visited = false;

    /**
     * @var int
     */
    protected $currentWeight = 0;

    /**
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
        $this->currentWeight = $this->originalWeight;
    }

    public function __toString()
    {
        return $this->getName() . "-" . $this->getOriginalWeight();
    }

    /**
     * Describe if the place will be walkable or not
     *
     * @return boolean
     */
    abstract public function isWalkable();

    /**
     * @param Place $leftRef
     * @return Place
     */
    public function setLeftRef(Place &$leftRef): Place
    {
        if( $this->leftRef )
            return $this;

        $this->leftRef = $leftRef;
        $leftRef->setRightRef($this);

        return $this;
    }

    /**
     * @param Place $rightRef
     * @return Place
     */
    public function setRightRef(Place &$rightRef): Place
    {
        if( $this->rightRef )
            return $this;

        $this->rightRef = $rightRef;
        $rightRef->setLeftRef($this);

        return $this;
    }

    /**
     * @param Place $topRef
     * @return Place
     */
    public function setTopRef(Place &$topRef): Place
    {
        if( $this->topRef )
            return $this;

        $this->topRef = $topRef;
        $topRef->setBottomRef($this);

        return $this;
    }

    /**
     * @param Place $bottomRef
     * @return Place
     */
    public function setBottomRef(Place &$bottomRef): Place
    {
        if( $this->bottomRef )
            return $this;

        $this->bottomRef = $bottomRef;
        $bottomRef->setTopRef($this);
        return $this;
    }

    /**
     * When walk the tree, when it arrives in this node, increase the value
     *
     * @param int $i
     */
    public function increaseCurrentWeight(int $i)
    {
        $this->currentWeight += $i;
    }

    /**
     * Set the currentWeight at the originalWeight
     */
    public function resetCurrentWeight()
    {
        $this->currentWeight = $this->originalWeight;
    }

    /**
     * @return int
     */
    public function getCurrentWeight()
    {
        return $this->currentWeight;
    }

    /**
     * @param int $currentWeight
     * @return Place
     */
    public function setCurrentWeight($currentWeight)
    {
        $this->currentWeight = $currentWeight;
        return $this;
    }

    /**
     * @return Place[]
     */
    public function getNeighbors()
    {
        return [
            $this->topRef,
            $this->rightRef,
            $this->bottomRef,
            $this->leftRef
        ];
    }

    /**
     * @return Place[]
     */
    public function getWalkableNeighbors()
    {
        return array_filter($this->getNeighbors(), function($place) {
            if( !$place )
                return false;

            return $place->isWalkable();
        });
    }

    /**
     * @param bool $visited
     * @return Place
     */
    public function setVisited($visited)
    {
        $this->visited = $visited;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->visited;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Place
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Place
     */
    public function getWalkingCameFrom()
    {
        return $this->walkingCameFrom;
    }

    /**
     * @param Place $walkingCameFrom
     * @return Place
     */
    public function setWalkingCameFrom(Place &$walkingCameFrom)
    {
        $this->walkingCameFrom = $walkingCameFrom;
        return $this;
    }

    /**
     * @return int
     */
    public function getOriginalWeight()
    {
        return $this->originalWeight;
    }

    /**
     * @return Place
     */
    public function reset()
    {
        $this->currentWeight = $this->originalWeight;
        $this->walkingCameFrom = null;

        return $this;
    }
}