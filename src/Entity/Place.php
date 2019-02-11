<?php

namespace GGGGino\WarehousePath\Entity;

abstract class Place
{
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
     * @var bool
     */
    protected $visited = false;

    /**
     * @var int
     */
    protected $weight = 0;

    /**
     * @param Place $leftRef
     * @return Place
     */
    public function setLeftRef(Place $leftRef): Place
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
    public function setRightRef(Place $rightRef): Place
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
    public function setTopRef(Place $topRef): Place
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
    public function setBottomRef(Place $bottomRef): Place
    {
        if( $this->bottomRef )
            return $this;

        $this->bottomRef = $bottomRef;
        $bottomRef->setTopRef($this);
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
}