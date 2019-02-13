<?php

namespace GGGGino\WarehousePath\Tools\Console;

use GGGGino\WarehousePath\Tools\Console\Command\GraphicalTestCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Handles running the Console Tools inside Symfony Console context.
 */
class ConsoleRunner
{
    /**
     * Runs console with the given helperset.
     *
     * @param Command[] $commands
     *
     * @return void
     */
    public static function run($commands = [])
    {
        $cli = new Application('Warehouse Command Line Interface');

        $cli->setCatchExceptions(true);

        self::addCommands($cli);

        $cli->run();
    }

    /**
     * @return void
     */
    public static function addCommands(Application $cli)
    {
        $cli->addCommands([
            new GraphicalTestCommand(),
        ]);
    }
}
