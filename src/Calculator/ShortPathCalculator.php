<?php

namespace GGGGino\WarehousePath\Calculator;

use GGGGino\WarehousePath\Entity\Place;

class ShortPathCalculator extends FastCalculator
{
    /**
     * The time the program will loop for the best path
     *
     * @var int
     */
    private $loopComplexity = 2;

    /**
     * @inheritdoc
     */
    public function calculate($arrayNodes, $matrix)
    {
        $arraySorted = parent::calculate($arrayNodes, $matrix);

        return $arraySorted;
    }
}