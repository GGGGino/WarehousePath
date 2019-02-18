# Places

Places are the main factor for calculating the best path from a Point A to B.

A warehouse can be seen as a matrix of Place that every item has its own weight. 
From this, the program can create the best path:

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

So the distance, adding all the weight in the path, will be:

1 + 1 + 1 + 2 + 1 = **6**

This library starts with these three places:

| Name          | Weight           | Walkable         |
| ------------- |:---------------- | ----------------:|
| Corridor      | 2                | true             |
| Location      | 1                | true             |
| Wall          | 100              | false            |

You can add as many type of Place as you want.