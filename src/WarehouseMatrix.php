<?php

namespace GGGGino\WarehousePath;

class WarehouseMatrix
{
    /**
     * The original matrix values
     *
     * @var array
     */
    private $originalMatrix;

    /**
     * The matrix with the calculatedObjects
     *
     * @var array
     */
    private $calculatedMatrix;

    /**
     * The matrix with the calculatedObjects
     *
     * @var array
     */
    private $calculatedArray;

    /**
     * The weight of the matrix
     *
     * @var int
     */
    private $width;

    /**
     * The height of the matrix
     *
     * @var int
     */
    private $height;

    /**
     * @var PlacesCollector
     */
    private $placeCollector;

    public function __construct(PlacesCollector $placeCollector)
    {
        $this->placeCollector = $placeCollector;
    }

    public function createByMatrix($matrix)
    {
        $this->calculatedMatrix = array();
        $this->setOriginalMatrix($matrix);
        $this->setWidth(count($matrix));
        $this->setHeight(count($matrix[0]));

        foreach($matrix as $rKey => $row) {
            foreach($row as $cKey => $column) {
                $placeType = $this->placeCollector->getPlaceTypeByWeight($column['weight']);
                $placeTypeNew = clone($placeType);

                $placeTypeNew->setName($rKey . $cKey);
                if( isset($matrix[$rKey - 1][$cKey]['obj']) ) {
                    $placeTypeNew->setLeftRef($matrix[$rKey - 1][$cKey]['obj']);
                }

                if( isset($matrix[$rKey][$cKey - 1]['obj']) ) {
                    $placeTypeNew->setRightRef($matrix[$rKey][$cKey - 1]['obj']);
                }

                $this->calculatedMatrix[$rKey][$cKey] = $placeTypeNew;
                $this->calculatedArray[] = $placeTypeNew;
                $matrix[$rKey][$cKey]['obj'] = $placeTypeNew;
            }
        }
    }

    /**
     * @param array $originalMatrix
     * @return WarehouseMatrix
     */
    public function setOriginalMatrix(array $originalMatrix): WarehouseMatrix
    {
        $this->originalMatrix = $originalMatrix;
        return $this;
    }

    /**
     * @param int $height
     * @return WarehouseMatrix
     */
    public function setHeight(int $height): WarehouseMatrix
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @param int $width
     * @return WarehouseMatrix
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return array
     */
    public function getCalculatedArray()
    {
        return $this->calculatedArray;
    }

    /**
     * @return array
     */
    public function getCalculatedMatrix()
    {
        return $this->calculatedMatrix;
    }
}