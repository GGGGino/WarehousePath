<?php

namespace GGGGino\WarehousePath;

use GGGGino\WarehousePath\Entity\Place;

class Edge
{
    /**
     * @var int
     */
    private $weight;

    /**
     * @var Place
     */
    private $vertice1;

    /**
     * @var Place
     */
    private $vertice2;

    public function __construct($vertice1, $vertice2, $weight = 0)
    {
        $this->vertice1 = $vertice1;
        $this->vertice2 = $vertice2;
        $this->weight = $weight;
    }

    /**
     * @param int $weight
     * @return Edge
     */
    public function setWeight(int $weight): Edge
    {
        $this->weight = $weight;
        return $this;
    }
}