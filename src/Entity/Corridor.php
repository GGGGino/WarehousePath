<?php

namespace GGGGino\WarehousePath\Entity;

class Corridor extends Place implements WalkableInterface
{
    public function __construct($name = "")
    {
        $this->originalWeight = 2;

        parent::__construct($name);
    }
}