<?php

namespace GGGGino\WarehousePath\Entity;

class Corridor extends Place implements WalkableInterface
{
    public function __construct()
    {
        $this->weight = 2;
    }
}