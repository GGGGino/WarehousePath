<?php

namespace GGGGino\WarehousePath\Breadcrumb;

use GGGGino\WarehousePath\Entity\Place;

interface BreadcrumbInterface
{
    /**
     * From a starting place($startPlace) I create the distance between every place.
     *
     * @param Place $startPlace
     * @param Place $endPlace if not null do early exit
     */
    public function createBreadcrumb(Place $startPlace, Place $endPlace = null);

    /**
     * Build the matrix with the distances
     *
     * @param Place[] $places
     * @return array
     */
    public function createMultipleBreadcrumb(array $places);
}