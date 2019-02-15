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
    protected $originalMatrix;

    /**
     * The original matrix values
     *
     * @var array
     */
    protected $calculatedMatrix;

    /**
     * The array with the calculated Objects
     *
     * @var array
     */
    protected $calculatedArray;

    /**
     * @var PlacesCollector
     */
    protected $placeCollector;

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
                $this->originalMatrix[$rKey][$cKey]['obj'] = $placeTypeNew;
            }
        }

        return $this->calculatedArray;
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

    /**
     * @return array
     */
    public function getCalculatedMatrix(): array
    {
        return $this->calculatedMatrix;
    }
}