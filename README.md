# GGGGinoWarehousePath

> Find the shortest path to retrieve all the objects in the own location

[![Build Status](https://travis-ci.com/GGGGino/WarehousePath.svg?branch=master)](https://travis-ci.com/GGGGino/WarehousePath)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GGGGino/WarehousePath/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GGGGino/WarehousePath/?branch=master)

# Get started

```
composer require ggggino/warehouse-path
```

#### Initialization from a give matrix

```php
use GGGGino\WarehousePath\Warehouse;

/** @var Warehouse $warehouse */
$warehouse = Warehouse::createFromMatrix(self::getSampleData());
```

#### Initialization from a give tree

```php
use GGGGino\WarehousePath\Warehouse;

/** @var Warehouse $warehouse */
$warehouse = Warehouse::createFromTree($arrayPlaces);
```

#### Initialization from a json

```php
use GGGGino\WarehousePath\Warehouse;

/** @var Warehouse $warehouse */
$warehouse = Warehouse::createFromJson(getcwd() . "/resources/simpleWarehouse.json")
```

# Places

Places are the base main factor for calculating the best path from a Point A to B.

A warehouse can be seen as a matrix of Place that every item has own weight. 
From this the program can create the best path:

**Lx** = Location 

**Wx** = Wall

**Cx** = Corridor

| L1 | W1 | L8 |
|:--:|:--:|:--:|
| L2 | W2 | L7 |
| L3 | C1 | L6 |
| L4 | C2 | L5 |

Imagine you start from the Place "L1", the best path to "L7" will be:

**L1** -> **L2** -> **L3** -> **C1** -> **L6** -> **L7**

So the distance adding all the weight in the path will be:

1 + 1 + 1 + 2 + 1 = **6**

This library starts with these three:

| Name          | Weight           | Walkable         |
| ------------- |:---------------- | ----------------:|
| Corridor      | 2                | true             |
| Location      | 1                | true             |
| Wall          | 100              | false            |

You can add as many type of Place as you want.

[Read the complete doc about Places](docs/places.md)
