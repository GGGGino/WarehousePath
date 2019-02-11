<?php

namespace GGGGino\WarehousePath\Entity;

class Wall extends Place
{
    public function __construct()
    {
        $this->weight = 1000;
    }
}