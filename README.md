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

public static function getSampleData()
{
    return array(
        array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
        array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
        array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
        array(array('weight' => 2), array('weight' => 2), array('weight' =>   2), array('weight' => 2), array('weight' => 2), array('weight' => 1))
    );
}

/** @var Warehouse $warehouse */
$warehouse = Warehouse::createFromMatrix(self::getSampleData());
```

#### Initialization from a give tree

```php
use GGGGino\WarehousePath\Warehouse;
        
$loc1 = new Location('L1');
$loc2 = new Location('L2');
$loc3 = new Location('L3');
$corridor1 = new Location('C1');

$loc1->setBottomRef($loc2);
$loc1->setRightRef($loc3);

$loc3->setBottomRef($loc3);

$arrayPlaces = array($loc1, $loc2, $loc3, $corridor1);
        
/** @var Warehouse $warehouse */
$warehouse = Warehouse::createFromTree($arrayPlaces);
```

#### Initialization from a json

[Look here](resources/simpleWarehouse.json) and [Here](resources/biggerWarehouse.json)
for a correct json used to build the warehouse

```php
use GGGGino\WarehousePath\Warehouse;

/** @var Warehouse $warehouse */
$warehouse = Warehouse::createFromJson(getcwd() . "/resources/simpleWarehouse.json")
```

### Get distance from a starting point to every other location
```php
/** @var Place $nodeStart */
$nodeStart = $calculatedArray[4];
$warehouse->getPath($nodeStart);
```

### Get the matrix of proximity

> Call the Warehouse::getPath for every single location passed in the array
```php
/** @var Place[] $arrayNodes array of the places to touch */
$arrayNodes = [...]

$matrix = $warehouse->getMultiplePath($arrayNodes);
```

### Best path

> Calculate the best path to touch every location from the matrix of proximity

```php
/** @var Place[] $arrayNodes array of the places to touch */
$arrayNodes = [...]

$arrayNodeSorted = $warehouse->calculate($arrayNodes, $matrix);
```

With this function you get the best path to follow to touch every location
in the warehouse/matrix.

# Places

Places are the main factor for calculating the best path from a Point A to B.

A warehouse can be seen as a matrix of Place that every item has own weight. 
From this, the program can create the best path:

**Lx** = Location - Weight 1

**Wx** = Wall - Weight 100

**Cx** = Corridor - Weight 2

| L1 | W1 | L8 |
|:--:|:--:|:--:|
| L2 | W2 | L7 |
| L3 | C1 | L6 |
| L4 | C2 | L5 |

Imagine you start from the Place "L1", the best path to "L7" will be:

**L1** -> **L2** -> **L3** -> **C1** -> **L6** -> **L7**

So the distance, adding all the weight in the path, will be:

1 + 1 + 1 + 2 + 1 = **6**

This library starts with these three places:

| Name          | Weight           | Walkable         |
| ------------- |:---------------- | ----------------:|
| Corridor      | 2                | true             |
| Location      | 1                | true             |
| Wall          | 100              | false            |

You can add as many type of Place as you want.

[Read the complete doc about Places](docs/places.md)
