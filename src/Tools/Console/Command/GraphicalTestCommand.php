<?php

namespace GGGGino\WarehousePath\Tools\Console\Command;

use GGGGino\WarehousePath\Entity\Place;
use GGGGino\WarehousePath\Warehouse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GraphicalTestCommand extends Command
{
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
        $warehouse = Warehouse::createFromJson(getcwd() . "/resources/biggerWarehouse.json");

        /** @var Place $nodeStart */
        $nodeStart = $warehouse->getPlacesCollector()->getPlaces()[5];
        /** @var Place $nodeEnd */
        $nodeEnd = $warehouse->getPlacesCollector()->getPlaces()[30];

        $warehouse->getPath($nodeStart, $nodeEnd);

        $calculatedMatrix = $warehouse->getParser()->getCalculatedMatrix();

        $table = new Table($output);
        $table->setRows($calculatedMatrix);
        $table->render();

        $output->writeln("Start: " . $nodeStart->getName());
        $output->writeln("End: " . $nodeEnd->getName());
        $output->writeln("Total path: " . $nodeEnd->getCurrentWeight());
    }
}
