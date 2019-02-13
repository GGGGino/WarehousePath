<?php

namespace GGGGino\WarehousePath\Tools\Console\Command;


use GGGGino\WarehousePath\Entity\Place;
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
        return array(
            array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
            array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
            array(array('weight' => 2), array('weight' => 1), array('weight' => 100), array('weight' => 1), array('weight' => 2), array('weight' => 1)),
            array(array('weight' => 2), array('weight' => 2), array('weight' =>   2), array('weight' => 2), array('weight' => 2), array('weight' => 1))
        );
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
        $nodeStart = $calculatedArray[4];
        /** @var Place $nodeEnd */
        $nodeEnd = $calculatedArray[20];

        $table = new Table($output);
        $table
            ->setRows($calculatedMatrix)
        ;
        $table->render();
    }
}
