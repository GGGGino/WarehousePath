<?php

namespace GGGGino\WarehousePath\Entity;

class Wall extends Place
{
    public function __construct($name = "")
    {
        $this->originalWeight = 1000;

        parent::__construct($name);
    }
}