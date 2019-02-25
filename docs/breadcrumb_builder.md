# Breadcrumb builder

The breadcrumb builder aim to create a matrix from the array of all places.
This matrix will be passed to the calculator that calculate the correct order
which is the correct path to touch all the places with the less cost possible.

## Breadth First

With this method I map the wharehouse expanding the area and keep in mind the previous 
state on every step. In this way I can realize a wharehouse that every place knows the shortest
path to specific point

With this builder you can use two callback to help you in building your path.

```php
$placesCollector = ...

$breadcrumbBuilder = new BreadthFirstBreadcrumb($placesCollector);
$breadcrumbBuilder->setOnWalk(function(Place $current) {});
$breadcrumbBuilder->setOnPreCreateBreadcumb(function(Place $startPlace, array $places) {});

$wm = new MatrixParser....;

$instance = new Warehouse($placesCollector, $wm, $breadcrumbBuilder);
```


## Create custom breadrumb builder

The custom Breadcrumb builder must implements `GGGGino\WarehousePath\Breadcrumb\BreadcrumbInterface`

[Read the complete doc about Breadcrumb](docs/breadcrumb_builder.md)