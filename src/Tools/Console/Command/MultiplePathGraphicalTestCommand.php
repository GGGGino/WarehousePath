<?php

namespace GGGGino\WarehousePath\Tools\Console\Command;


use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\JsonReader;
use GGGGino\WarehousePath\Warehouse;
use GGGGino\WarehousePath\WarehouseTree;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WarehouseMatrixTest;

class MultiplePathGraphicalTestCommand extends Command
{
    /**
     * Super simple warehouse representation
     *
     * @return array
     */
    public static function getMatrixSimple()
    {
        $jsonReader = new JsonReader(getcwd() . "/../resources/biggerWarehouse.json");
        return $jsonReader->readAndParse()['warehouse'];
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ggggino:warehouse:mpg-print-matrix')
            ->setDescription('Print a beautiful matrix with the lenght of every path')
            ->setHelp(<<<EOT
Print a beautiful matrix.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $testMatrix = Warehouse::createMatrix(self::getMatrixSimple());
        $calculatedArray = $testMatrix->getCalculatedArray();

        $wt = new WarehouseTree($calculatedArray);

        /** @var Place $startingPoint */
        $startingPoint = $calculatedArray[103];

        /** @var Place[] $arrayNodes */
        $arrayNodes = array(
            $startingPoint,
            $calculatedArray[30],
            $calculatedArray[23],
            $calculatedArray[57],
            $calculatedArray[135],
            $calculatedArray[120],
            $calculatedArray[115],
            $calculatedArray[79],
            $calculatedArray[601],
            $calculatedArray[650]
        );

        $matrix = $wt->getMultiplePath($arrayNodes);

        $table = new Table($output);
        $table
            ->setHeaders($arrayNodes)
            ->setRows($matrix)
        ;
        $table->render();

        $wt->getMinimumPath($arrayNodes, $matrix);
    }
}
