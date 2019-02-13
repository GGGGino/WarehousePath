<?php

use GGGGino\WarehousePath\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Helper\HelperSet;

$files       = [__DIR__ . '/../vendor/autoload.php', __DIR__ . '/../../../autoload.php'];
$loader      = null;
$cwd         = getcwd();
$directories = [$cwd, $cwd . DIRECTORY_SEPARATOR . 'config'];
$configFile  = null;

foreach ($files as $file) {
    if (file_exists($file)) {
        $loader = require $file;

        break;
    }
}

if (! $loader) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

$commands  = [];

ConsoleRunner::run($commands);
