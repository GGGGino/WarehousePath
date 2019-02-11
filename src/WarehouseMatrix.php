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
     * @param array $originalMatrix
     * @return WarehouseMatrix
     */
    public static function createFromMatrix($originalMatrix)
    {
        $instance = new self();
        $instance->setOriginalMatrix($originalMatrix);
        $instance->setWidth(count($originalMatrix));
        // @todo only temporary, calculate better this line under
        $instance->setHeight(count($originalMatrix[0]));

        return $instance;
    }

    /**
     * @return WarehouseMatrix
     */
    public static function createFromDimension($width, $height)
    {
        $instance = new self();
        $instance->setWidth($width);
        $instance->setHeight($height);

        return $instance;
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
}