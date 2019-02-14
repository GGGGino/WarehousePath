<?php

namespace GGGGino\WarehousePath\Calculator;

use GGGGino\WarehousePath\Entity\Place;

interface CalculatorInterface
{
    /**
     * This is the main method that calculate the best path from the matrix with the distance between
     * every location.
     *
     * @param $arrayNodes array
     *      The array of the places to find.
     *       +-------+------+------+------+-------+-------+-------+------+-------+-------+
     *       | 114-2 | 33-1 | 25-1 | 63-1 | 150-2 | 133-1 | 127-2 | 87-2 | 667-1 | 722-2 |
     *       +-------+------+------+------+-------+-------+-------+------+-------+-------+
     *
     *      es.
     *      114 (the left number) - Virtual name of the point
     *      2 (the right number) - Weight of the Location
     *
     * @param $matrix
     *      Matrix representtation of the combination of the distances between every Place.
     *           +-------+------+------+------+-------+-------+-------+------+-------+-------+
     *           | 114-2 | 33-1 | 25-1 | 63-1 | 150-2 | 133-1 | 127-2 | 87-2 | 667-1 | 722-2 |
     *           +-------+------+------+------+-------+-------+-------+------+-------+-------+
     *     114-2 | 2     | 13   | 14   | 9    | 14    | 6     | 9     | 11   | 78    | 85    |
     *      33-1 | 13    | 1    | 5    | 5    | 22    | 14    | 20    | 15   | 89    | 93    |
     *      25-1 | 14    | 5    | 1    | 9    | 26    | 18    | 18    | 13   | 87    | 97    |
     *      63-1 | 9     | 5    | 9    | 1    | 18    | 10    | 16    | 11   | 85    | 89    |
     *     150-2 | 14    | 22   | 26   | 18   | 2     | 12    | 19    | 23   | 80    | 80    |
     *     133-1 | 6     | 14   | 18   | 10   | 12    | 1     | 10    | 15   | 76    | 80    |
     *     127-2 | 9     | 20   | 18   | 16   | 19    | 10    | 2     | 7    | 71    | 89    |
     *      87-2 | 11    | 15   | 13   | 11   | 23    | 15    | 7     | 2    | 76    | 94    |
     *     667-1 | 78    | 89   | 87   | 85   | 80    | 76    | 71    | 76   | 1     | 19    |
     *     722-2 | 85    | 93   | 97   | 89   | 80    | 80    | 89    | 94   | 19    | 2     |
     *           +-------+------+------+------+-------+-------+-------+------+-------+-------+
     *
     * @return Place[]
     *      return the list of the Places sorted by the minimum path
     */
    public function calculate($arrayNodes, $matrix);
}