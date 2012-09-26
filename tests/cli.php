#!/bin/env php
<?php
// error reporting on
error_reporting(E_ALL);

// chdir to root test direcotry in any case
chdir(__DIR__);

// requiere test-autoloader environment
require_once('autoloader.php');
$loader = new \Spaf\tests\Autoloader(false);

// instantiate manager
$manager = new \Spaf\Library\Test\Manager();
// set class prefix for testing
$manager->setClassPrefix('Spaf\\tests');
// run test manager
$manager->run();

?>