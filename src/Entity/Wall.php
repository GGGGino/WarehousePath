<?php

namespace GGGGino\WarehousePath\Entity;

class Wall extends Place
{
    public function __construct($name = "")
    {
        $this->originalWeight = 100;

        parent::__construct($name);
    }
}