<?php

namespace GGGGino\WarehousePath\Tools\Console\Command;

use GGGGino\WarehousePath\Calculator\FastCalculator;
use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Warehouse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MultiplePathGraphicalTestCommand extends Command
{
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
        /** @var Warehouse $warehouse */
        $warehouse = Warehouse::createFromJson(getcwd() . "/../resources/biggerWarehouse.json");
        $calculatedArray = $warehouse->getPlacesCollector()->getPlaces();

        $warehouse->setPathCalculator(new FastCalculator());

        /** @var Place[] $arrayNodes */
        $arrayNodes = $this->chooseSearchablePlaces($calculatedArray);

        $matrix = $warehouse->getMultiplePath($arrayNodes);

        $this->printTable($output, $arrayNodes, $matrix);

        $warehouse->calculate($arrayNodes, $matrix);
    }

    /**
     * Output the table for debug purpose
     *
     * @param OutputInterface $output
     * @param array $arrayNodes
     * @param array $matrix
     */
    private function printTable(OutputInterface $output, array $arrayNodes, array $matrix)
    {
        $table = new Table($output);
        $table
            ->setHeaders($arrayNodes)
            ->setRows($matrix)
        ;
        $table->render();
    }

    /**
     * Select the Places for find the path
     *
     * @param Place[] $calculatedArray
     * @return Place[]
     */
    private function chooseSearchablePlaces($calculatedArray)
    {
        return array(
            $calculatedArray[103],
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
    }
}
