<?php

namespace GGGGino\WarehousePath\Calculator;

use GGGGino\WarehousePath\Entity\Place;

class FastCalculator implements CalculatorInterface
{
    /**
     * @inheritdoc
     */
    public function calculate($arrayNodes, $matrix)
    {
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

        return $arraySorted;
    }
}