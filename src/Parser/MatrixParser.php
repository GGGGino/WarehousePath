<?php

namespace GGGGino\WarehousePath\Parser;

use GGGGino\WarehousePath\PlacesCollector;

class MatrixParser implements ParserInterface
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
                if( isset($matrix[$rKey - 1][$cKey]['obj']) ) {
                    $placeTypeNew->setTopRef($matrix[$rKey - 1][$cKey]['obj']);
                }

                if( isset($matrix[$rKey][$cKey - 1]['obj']) ) {
                    $placeTypeNew->setLeftRef($matrix[$rKey][$cKey - 1]['obj']);
                }

                $this->calculatedMatrix[$rKey][$cKey] = $placeTypeNew;
                $this->calculatedArray[] = $placeTypeNew;
                $matrix[$rKey][$cKey]['obj'] = $placeTypeNew;
            }
        }
    }

    /**
     * @param array $originalMatrix
     * @return MatrixParser
     */
    public function setOriginalMatrix($originalMatrix)
    {
        $this->originalMatrix = $originalMatrix;
        return $this;
    }
}