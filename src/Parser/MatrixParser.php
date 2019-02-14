<?php

namespace GGGGino\WarehousePath\Parser;

class MatrixParser implements ParserInterface
{
    /**
     * @return mixed
     */
    public function parse()
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
}