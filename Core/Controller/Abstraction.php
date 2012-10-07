<?php

/**
 * $Id$
 *
 * Spaf/Core/Controller/Abstraction.php
 * @created Tue Jun 10 19:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Controller;

/**
 * \Spaf\Core\Controller\Abstraction
 *
 * Thats a base controller classe.
 * Any concrete controller should extend this class.
 *
 * @author Claudio Walser
 * @package \Spaf\Core\Controller
 * @namespace \Spaf\Core\Controller
 * @abstract
 */
abstract class Abstraction {

	/**
	 * The Registry Object.
	 *
	 * @var \Spaf\Core\Registry
	 */
	protected $_registry = null;

	/**
	 * Request Object
	 *
	 * @var Spaf\Core\Request
	 */
	protected $_request = null;

	/**
	 * Response Object
	 *
	 * @var Spaf\Core\Response
	 */
	protected $_response = null;

	/**
	 * Config Object
	 *
	 * @var Spaf\Library\Config
	 */
	protected $_config = null;

	/**
	 * Session Object
	 *
	 * @var Spaf\Library\Session
	 */
	protected $_session = null;

    /**
     * Creates a controller object and
     * set the default properties in this class.
     * Some of them are coming from the registry.
	 *
	 * @throws \Spaf\Core\Exception Throws an Exception if no request object is set in the Registry yet
	 * @throws \Spaf\Core\Exception Throws an Exception if no response object is set in the Registry yet
	 *
	 * @param \Spaf\Core\Registry Pass a registry object by injection
     */
	public function __construct(\Spaf\Core\Registry $registry) {
		$this->_registry = $registry;

		// throws exceptions if request or response object is not set yet
		$this->_request = $this->_registry->get('request', true);
		$this->_response = $this->_registry->get('response', true);

		// call the init method
		$this->init();
	}

	/**
	 * Default listing if a called method isnt implemented
	 *
	 * @throws \Spaf\Core\Controller\Exception Throws a controller exception if a method is called and not implemented
	 * @param string Name of the method which is just called
	 * @param array Arguments for this call
	 * @return void
	 */
	public function __call($name, $arguments) {
		throw new Exception(get_class($this) . ': Method "' . $name . '" is not implemented');
	}

	/**
	 * Empty init function which is called every time.
	 * Can be usefull to set something up, used in the whole controller.
	 */
	public function init() {}

}

?>
