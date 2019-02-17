# GGGGinoWarehousePath

> Find the shortest path to retrieve all the objects in the own location

# Get started

```
composer require ggggino/warehouse-path
```

## Initialization from a give matrix

```php
use GGGGino\WarehousePath\Warehouse;
$warehouse = Warehouse::createFromMatrix(self::getSampleData());
```

## Initialization from a give tree

```php
use GGGGino\WarehousePath\Warehouse;
$warehouse = Warehouse::createFromTree($arrayPlaces);
```

## Initialization from a json

```php
use GGGGino\WarehousePath\Warehouse;
$warehouse = Warehouse::createFromJson(getcwd() . "/resources/simpleWarehouse.json")
```