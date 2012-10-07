#!/bin/env php
<?php

/**
 * $Id$
 *
 * Spaf/tests/cli.php
 * @created Tue Sep 25 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

// hack server argv for windows console
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
$loader = new \Spaf\_tests\Unit\Autoloader(false);

// instantiate manager
$manager = new \Spaf\Library\TestManager\Cli();
// set class prefix for testing
$manager->setClassPrefix('Spaf\\_tests');
// run test manager
$manager->run();

?>
