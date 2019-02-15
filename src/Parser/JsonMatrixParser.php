<?php

namespace GGGGino\WarehousePath\Parser;

use GGGGino\WarehousePath\PlacesCollector;

class JsonMatrixParser extends MatrixParser
{
    /**
     * @var string
     */
    private $pathFile;

    /**
     * @var array
     */
    private $jsonParsed;

    public function __construct(string $path, PlacesCollector $placeCollector)
    {
        $this->pathFile = $path;
        $this->jsonParsed = $this->readAndParse();

        parent::__construct($this->jsonParsed, $placeCollector);
    }

    /**
     * @return array
     */
    public function readAndParse()
    {
        $string = file_get_contents($this->pathFile);
        $fileContent = json_decode($string, true);

        return $fileContent['warehouse'];
    }
}