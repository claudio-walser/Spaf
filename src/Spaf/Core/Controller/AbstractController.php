<?php

/**
 * $Id$
 *
 * Spaf/Core/Controller/AbstractController.php
 * @created Tue Jun 10 19:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Controller;

/**
 * \Spaf\Core\Controller\AbstractController
 *
 * Thats a base controller classe.
 * Any concrete controller should extend this class.
 *
 * @author Claudio Walser
 * @package Spaf\Core\Controller
 * @namespace Spaf\Core\Controller
 * @abstract
 */
abstract class AbstractController {

	protected $_dispatcher = null;

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
	 *
	 */
	protected $_application = null;
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
	public function __construct(\Spaf\Core\Application $application) {
		$this->_application = $application;
		$this->_registry = $this->_application->getRegistry();

		// throws exceptions if request or response object is not set yet
		$this->_request = $this->_application->getRequest();
		$this->_response = $this->_application->getResponse();

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
	
	protected function controller($controller, $action, $params) {
		if ($this->_application === null) {
			$this->_createPhpApplication();
		}

		// execute and get controllers return
		return $this->_application->run($controller, $action, $params);
	}

	protected function _createPhpApplication() {		
		// instantiate business tier with a php request and response
		$this->_application = new \Spaf\Core\Application('php');
	}
}

?>