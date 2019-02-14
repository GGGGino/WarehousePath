<?php

namespace GGGGino\WarehousePath\Parser;

use GGGGino\WarehousePath\PlacesCollector;

class JsonMatrixParser extends MatrixParser
{
    /**
     * The original matrix values
     *
     * @var array
     */
    private $originalMatrix;

    /**
     * The original matrix values
     *
     * @var array
     */
    private $calculatedMatrix;

    /**
     * The array with the calculated Objects
     *
     * @var array
     */
    private $calculatedArray;

    /**
     * @var PlacesCollector
     */
    private $placeCollector;

    public function __construct(array $originalMatrix, PlacesCollector $placeCollector)
    {
        $this->calculatedMatrix = array();
        $this->originalMatrix = $originalMatrix;
        $this->placeCollector = $placeCollector;
    }

    /**
     * @return mixed
     */
    public function parse()
    {
        foreach($this->originalMatrix as $rKey => $row) {
            foreach($row as $cKey => $column) {
                $placeType = $this->placeCollector->getPlaceTypeByWeight($column['weight']);
                $placeTypeNew = clone($placeType);

                $placeTypeNew->setName($rKey . $cKey);
                if( isset($this->originalMatrix[$rKey - 1][$cKey]['obj']) ) {
                    $placeTypeNew->setTopRef($this->originalMatrix[$rKey - 1][$cKey]['obj']);
                }

                if( isset($this->originalMatrix[$rKey][$cKey - 1]['obj']) ) {
                    $placeTypeNew->setLeftRef($this->originalMatrix[$rKey][$cKey - 1]['obj']);
                }

                $this->calculatedMatrix[$rKey][$cKey] = $placeTypeNew;
                $this->calculatedArray[] = $placeTypeNew;
                $matrix[$rKey][$cKey]['obj'] = $placeTypeNew;
            }
        }
    }
}