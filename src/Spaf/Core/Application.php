<?php

/**
 * $ID$
 *
 * Spaf/Core/Application.php
 * @created Wed Aug 18 18:42:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core;

/**
 * \Spaf\Core\Application
 *
 * Application class.
 * Extends Dispatcher class to delegate the request
 * and call the right controller.
 *
 * @author Claudio Walser
 * @package Spaf\Core
 * @namespace Spaf\Core
 */
class Application extends Dispatcher {

	/**
	 * Constructor
	 *
	 * Set default registry
	 */
	public function __construct() {
		$this->setRegistry(Registry::getInstance());

	}

}

?>