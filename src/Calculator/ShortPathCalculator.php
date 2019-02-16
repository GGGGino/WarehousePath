<?php

namespace GGGGino\WarehousePath\Calculator;

use GGGGino\WarehousePath\Entity\Place;

class ShortPathCalculator implements CalculatorInterface
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
        for($i = 0; $i < $this->loopComplexity; $i++) {
            /** @var Place $startingPoint */
            $startingPoint = $arrayNodes[0];

            $arraySorted = array($startingPoint);

            while (count($matrix) > 1) {
                $arrayNodeKey = null;

                foreach ($arrayNodes as $key => $node) {
                    if ( $node === $startingPoint ) {
                        $arrayNodeKey = $key;
                        break;
                    }
                }

                /** @var int $minimumFoundKey */
                $minimumFoundKey = $arrayNodeKey;
                /** @var int $minimumFound */
                $minimumFound = INF;

                /** @var int $nodeWeight */
                foreach ($matrix[$arrayNodeKey] as $key => $nodeWeight) {
                    if( $key == $arrayNodeKey )
                        continue;

                    if( $minimumFound > $nodeWeight ){
                        $minimumFound = $nodeWeight;
                        $minimumFoundKey = $key;
                    }
                }

                $startingPoint = $arrayNodes[$minimumFoundKey];
                $arraySorted[] = $startingPoint;
                unset($matrix[$arrayNodeKey]);
                /** @var int $nodeWeight */
                foreach ($matrix as $key => $nodeWeight) {
                    unset($matrix[$key][$arrayNodeKey]);
                }
                unset($arrayNodes[$arrayNodeKey]);
            }
        }

        return $arraySorted;
    }
}