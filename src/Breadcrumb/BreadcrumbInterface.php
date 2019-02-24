<?php

namespace GGGGino\WarehousePath\Breadcrumb;

use GGGGino\WarehousePath\Entity\Place;

interface BreadcrumbInterface
{
    /**
     * Main algorithm to find the shortest path.
     *
     * @param Place $startPlace
     * @param Place $endPlace if not null do early exit
     */
    public function createBreadcrumb(Place $startPlace, Place $endPlace = null);
}