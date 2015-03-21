#!/usr/bin/env php
<?php

require __DIR__ . '/bootstrap/start.php';

use Symfony\Component\Console\Application;
use Vortex\Config\Config;

Config::setDirScan( __DIR__ . '/app/config' );


$app = new Application('Vortex', '1.0');

$app->add(new DBExportCommand);
$app->add(new DBExportSchemaCommand);
$app->add(new DBImportCommand);
$app->add(new GenerateControllerCommand);
$app->add(new GenerateCommand);
$app->run();