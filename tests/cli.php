#!/bin/env php
<?php
// harck server argv for windows console
if (!isset($_SERVER['argv']) && !empty($_GET)) {
    $_SERVER['argv'] = array('scriptname');
    
    foreach ($_GET as $key => $value) {
        $_SERVER['argv'][] = $key;
    }
}

// error reporting on
error_reporting(E_ALL);

// chdir to root test direcotry in any case
chdir(__DIR__);

// requiere test-autoloader environment
require_once('autoloader.php');
$loader = new \Spaf\tests\Unit\Autoloader(false);

// instantiate manager
$manager = new \Spaf\Library\TestManager\Cli();
// set class prefix for testing
$manager->setClassPrefix('Spaf\\tests');
// run test manager
$manager->run();

?>