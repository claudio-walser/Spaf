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
namespace Spaf\_tools;

// hack server argv for windows console
if (!isset($_SERVER['argv']) && !empty($_GET)) {
	$_SERVER['argv'] = array('scriptname');

	foreach ($_GET as $key => $value) {
		$_SERVER['argv'][] = $key;
	}
}

// error reporting on
error_reporting(E_ALL);

// chdir to root _tools direcotry in any case
chdir(__DIR__);

// requiere test-autoloader environment
require_once('autoloader.php');
$loader = new \Spaf\_tools\Autoloader(false);

// instantiate manager
$beautifier = new \Spaf\Library\Php\Beautifier();
$directory = new \Spaf\Library\Directory\Directory('../');
$files = $directory->getChildren('*.php', 'file', true);

$beautifier->setFiles($files);
$beautifier->beautify();

foreach ($files as $file) {
	// path of the original file
	$orig = $file->getPath() . $file->getName();
	// new path
	$new = '../../SpafDuplicate/' . substr($orig, 3, strlen($orig));
	// write the file to the new path
	try {
		$file->write($orig);
	} catch (\Spaf\Library\Directory\Exception $e) {
		// thrown if try to save an empty file, we have some int our _tests/Data folder
	}
}

?>