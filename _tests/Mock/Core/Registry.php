<?php

/**
 * $Id$
 *
 * Spaf/_tests/Mock/Core/Registry.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Mock\Core;

/**
 * \Spaf\_tests\Mock\Core\Registry
 *
 * Mocking of \Spaf\Core\Registry.
 *
 * @author Claudio Walser
 * @package \Spaf\_tests\Mock\Core
 * @namespace \Spaf\_tests\Mock\Core
 */
class Registry extends \Spaf\Core\Registry {

	/**
	 * Instance store
	 *
	 * @var \Spaf\_tests\Mock\Core\Registry
	 */
	private static $_instance = null;

	/**
	 * Private methods for beeing singleton
	 */
	private function __construct() {}
	private function __clone() {}

	/**
	 * mock get instance, return the mock for sure
	 *
	 * @return \Spaf\_tests\Mock\Core\Registry
	 */
	public static function getInstance(\Spaf\Core\Registry $registry = null) {
		// if instance still is NULL
		if (self::$_instance === null) {
			// create new one of myself
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}

?>