#!/bin/env php
<?php

// chdir to root test direcotry in any case
chdir(__DIR__);

require_once('autoloader.php');
$loader = new \Spaf\tests\Autoloader(false);

$manager = new \Spaf\Library\Test\Manager();
$manager->setClassPrefix('Spaf\\tests');
$manager->run();

?>