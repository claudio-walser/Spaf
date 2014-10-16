<?php

/**
 * $Id$
 *
 * Spaf/tests/autoloader.php
 * @created Wed Sep 26 20:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tools;

// Spaf abstract autoloader class for extending here
require_once('../src/Spaf/Core/Autoloader.php');

/**
 * \Spaf\tests\Autoloader
 *
 * Autoloader for test environment.
 *
 * @author Claudio Walser
 * @package Spaf\tools
 * @namespace Spaf\tools
 */
final class Autoloader Extends \Spaf\Core\Autoloader {

	protected $_lookupPaths = array(
		'../src/',
		'../../'
	);

	public function __construct() {
		// phpunit procedural autoload functions
		require_once('PHPUnit/Autoload.php');

		parent::__construct();
	}

}

?>
