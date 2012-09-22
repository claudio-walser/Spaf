<?php
/**
 * $ID$
 *
 * Test
 * Business.php
 */
namespace Cwa\Core;


/**
 * Business class
 * Main business tier class.
 * Instantiates Dispatcher/Controller objects and delegates the request
 * to get/set data
 *
 * @author		Claudio Walser
 */
class Business {


	/**
	 * Registry Object
	 *
	 * @var Cwa\Core\Registry
	 */
	private $_registry = null;

	/**
	 * Request Object
	 *
	 * @var Cwa\Core\Request
	 */
	private $_request = null;

	/**
	 * Response Object
	 *
	 * @var Cwa\Core\Response
	 */
	private $_response = null;
	
	private $_notFoundController = null;
	private $_defaultController = null;
	private $_defaultAction = null;
	
	/**
	 * Constructor
	 *
	 * Instantiates Request/Response objects
	 * and save them persistent in the registry.
	 *
	 * @param	Cwa\Core\Request	The request object
	 * @param	Cwa\Core\Response	The response object
	 */
	public function __construct(\Cwa\Core\Request\AbstractRequest $request, \Cwa\Core\Response\AbstractResponse $response) {
		$this->_registry = Registry::getInstance();

		$this->_request = $request;
		$this->_response = $response;

		$this->_registry->set('request', $this->_request, true);
		$this->_registry->set('response', $this->_response, true);
	}

	/**
	 * run the dispatcher
	 *
	 * Instantiates a dispatcher object
	 * and run the current request params
	 *
	 * @return		mixed		Returns the controllers individual return
	 */
	public function run() {
		$dispatcher = new Dispatcher();
		if ($this->_notFoundController !== null) {
			$dispatcher->setNotFoundController($this->_notFoundController);
		}
		if ($this->_defaultController !== null) {
			$dispatcher->setDefaultController($this->_defaultController);
		}		
		if ($this->_defaultAction !== null) {
			$dispatcher->setDefaultAction($this->_defaultAction);
		}
		return $dispatcher->dispatch();
	}

	/**
	 * set the default controller
	 *
	 * Change the property of the default container.
	 *
	 * @param	string		the default controller
	 * @return	boolean
	 */
	public function setDefaultController($controller) {
		$this->_defaultController = (string) $controller;
		return true;
	}
	
	/**
	 * set the not found controller
	 *
	 * Change the property of the not found container.
	 *
	 * @param	string		the not found controller
	 * @return	boolean
	 */
	public function setNotFoundController($controller) {
		$this->_notFoundController = (string) $controller;
		return true;
	}	


	/**
	 * set the default action
	 *
	 * Change the property of the default container-action.
	 *
	 * @param	string		the default action
	 * @return	boolean
	 */
	public function setDefaultAction($action) {
		$this->_defaultAction = (string) $action;
		return true;
	}
}

?>