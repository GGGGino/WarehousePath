<?php

namespace GGGGino\WarehousePath;


class JsonReader
{
    /**
     * @var string
     */
    private $pathFile;

    /**
     * @var array
     */
    private $jsonParsed;

    public function __construct(string $pathFile)
    {
        $this->pathFile = $pathFile;
    }

    public function readAndParse()
    {
        $string = file_get_contents($this->pathFile);
        $this->jsonParsed = json_decode($string, true);

        return $this->jsonParsed;
    }
}