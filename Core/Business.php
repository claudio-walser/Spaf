<?php
/**
 * $ID$
 *
 * Business.php
 * @created 	Wed Aug 18 18:42:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 */
namespace Spaf\Core;

/**
 * Business class
 * Main business tier class.
 * Instantiates Dispatcher/Controller objects and delegates the request
 * to get/set data
 * There are also methods to inject all those objects as mock objects for testing purpose.
 *
 * @author		Claudio Walser
 * @package		\Spaf\Core
 * @namespace	\Spaf\Core
 * */
class Business {

	/**
	 * Registry Object
	 *
	 * @var \Spaf\Core\Registry
	 */
	private $_registry = null;


	/**
	 * Dispatcher Object
	 *
	 * @var \Spaf\Core\Dispatcher
	 */
	private $_dispatcher = null;

	/**
	 * Request Object
	 *
	 * @var \Spaf\Core\Request
	 */
	private $_request = null;

	/**
	 * Response Object
	 *
	 * @var \Spaf\Core\Response
	 */
	private $_response = null;
	
	/**
	 * Name of the not-found controller action
	 * 
	 * @var string
	 */
	private $_notFoundController = null;

	/**
	 * Name of the default controller
	 * 
	 * @var string
	 */
	private $_defaultController = null;
	
	/**
	 * Name of the default controller action
	 * 
	 * @var string
	 */
	private $_defaultAction = null;
	
	/**
	 * Constructor
	 *
	 * Instantiates Request/Response objects
	 * and save them persistent in the registry.
	 *
	 * @param \Spaf\Core\Request The request object
	 * @param \Spaf\Core\Response The response object
	 */
	public function __construct(\Spaf\Core\Request\AbstractRequest $request, \Spaf\Core\Response\AbstractResponse $response) {
		$this->_registry = Registry::getInstance();
		$this->_dispatcher = new Dispatcher();
		$this->_request = $request;
		$this->_response = $response;
	}
	
	/**
	 * Public method to inject another Registry class
	 * This is only usefull for testing purposes
	 * 
	 * @param \Spaf\Core\Registry
	 * @return boolean true
	 */
	public function setRegistry(\Spaf\Core\Registry $registry) {
		$this->_registry = $registry;
		
		return true;
	}

	/**
	 * Public method to inject another Dispatcher class
	 * This is only usefull for testing purposes
	 * 
	 * @param \Spaf\Core\Dispatcher The Dispatcher object
	 * @return boolean true
	 */
	public function setDispatcher(\Spaf\Core\Dispatcher $dispatcher) {
		$this->_dispatcher = $dispatcher;
		
		return true;
	}
	
	/**
	 * Change the property of the default controller.
	 *
	 * @param string The default controller
	 * @return boolean true
	 */
	public function setDefaultController($controller) {
		$this->_defaultController = (string) $controller;
		
		return true;
	}
	
	/**
	 * Change the property of the not found controller.
	 *
	 * @param string The not found controller
	 * @return boolean true
	 */
	public function setNotFoundController($controller) {
		$this->_notFoundController = (string) $controller;
		
		return true;
	}	

	/**
	 * Change the property of the default controller-action.
	 *
	 * @param string The default action
	 * @return boolean true
	 */
	public function setDefaultAction($action) {
		$this->_defaultAction = (string) $action;
		
		return true;
	}
	
	/**
	 * Instantiates a dispatcher object
	 * and run the current request params
	 *
	 * @return mixed Returns the controllers method individual return
	 */
	public function run() {
		// setup registry params
		$this->_registry->set('request', $this->_request, true);
		$this->_registry->set('response', $this->_response, true);
		
		// setup dispatcher
		if ($this->_notFoundController !== null) {
			$this->_dispatcher->setNotFoundController($this->_notFoundController);
		}
		if ($this->_defaultController !== null) {
			$this->_dispatcher->setDefaultController($this->_defaultController);
		}		
		if ($this->_defaultAction !== null) {
			$this->_dispatcher->setDefaultAction($this->_defaultAction);
		}
		
		// forwards the dispatchers return, which is in fact the return value of a specific controller method
		return $this->_dispatcher->dispatch();
	}
	
}

?>