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

class GraphicalTestCommand extends Command
{
    /**
     * Super simple warehouse representation
     *
     * @return array
     */
    public static function getMatrixSimple()
    {
        $jsonReader = new JsonReader(getcwd() . "/resources/simpleWarehouse.json");
        return $jsonReader->readAndParse()['warehouse'];
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ggggino:warehouse:print-matrix')
            ->setDescription('Print a beautiful matrix')
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
        $calculatedMatrix = $testMatrix->getCalculatedMatrix();

        $wt = new WarehouseTree($calculatedArray);

        /** @var Place $nodeStart */
        $nodeStart = $calculatedArray[5];
        /** @var Place $nodeEnd */
        $nodeEnd = $calculatedArray[30];

        $wt->getPath($nodeStart, $nodeEnd);

        $table = new Table($output);
        $table
            ->setRows($calculatedMatrix)
        ;
        $table->render();

        $output->writeln("Start: " . $nodeStart->getName());
        $output->writeln("End: " . $nodeEnd->getName());
        $output->writeln("Total path: " . $nodeEnd->getCurrentWeight());
    }
}
