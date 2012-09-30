<?php

/**
 * $ID$
 *
 * Spaf/Core/Main.php
 * @created Wed Aug 18 18:42:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core;

/**
 * \Spaf\Core\Main
 * 
 * Main class.
 * Instantiates Dispatcher/Controller objects and delegates the request
 * to get/set data
 * There are also methods to inject all those objects as mock objects for testing purpose.
 *
 * @author Claudio Walser
 * @package \Spaf\Core
 * @namespace \Spaf\Core
 */
class Main {

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
	 * @var \Spaf\Core\Request\Abstraction
	 */
	private $_request = null;

	/**
	 * Response Object
	 *
	 * @var \Spaf\Core\Response\Abstraction
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
	 */
	public function __construct() {
		$this->_dispatcher = new Dispatcher();
		$this->setRegistry(Registry::getInstance());
		
		$this->_request = $this->_registry->get('request'. null);
		$this->_response = $this->_registry->get('response'. null);;
	}
	
	/**
	 * Public method to inject another Registry class
	 * This is only usefull for testing purposes
	 * 
	 * @param \Spaf\Core\Registry
	 * @param boolean Call Dispatchers setRegistry as well with the new object, default to true
	 * @return boolean true
	 */
	public function setRegistry(\Spaf\Core\Registry $registry, $updateDispatcher = true) {
		$this->_registry = $registry;
		
		if ($updateDispatcher === true) {
			$this->_dispatcher->setRegistry($this->_registry);
		}
		
		return true;
	}
	
	/**
	 * Public method get the Registry object
	 * 
	 * @return \Spaf\Core\Registry
	 */
	public function getRegistry() {
		return $this->_registry;
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
	 * Public method get the Dispatcher object
	 * 
	 * @return \Spaf\Core\Dispatcher
	 */
	public function getDispatcher() {
		return $this->_dispatcher;
	}
	
	/**
	 * Public method to inject a request class
	 * 
	 * @param \Spaf\Core\Request\Abstraction The request object
	 * @return boolean true
	 */
	public function setRequest(\Spaf\Core\Request\Abstraction $request) {
		$this->_request = $request;
		
		return true;
	}
	
	/**
	 * Public method to get the Request object
	 * 
	 * @return \Spaf\Core\Request\Abstraction
	 */
	public function getRequest() {
		return $this->_request;
	}
	
	/**
	 * Public method to inject a response class
	 * 
	 * @param \Spaf\Core\Response\Response The response object
	 * @return boolean true
	 */
	public function setResponse(\Spaf\Core\Response\Abstraction $response) {
		$this->_response = $response;
		
		return true;
	}
	
	/**
	 * Public method to get the Response object
	 * 
	 * @return \Spaf\Core\Response\Abstraction
	 */
	public function getResponse() {
		return $this->_response;
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
	 * Public method to get the DefaultController string
	 * 
	 * @return string Default Controller String
	 */
	public function getDefaultController() {
		return $this->_defaultController;
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
	 * Public method to get the NotFoundController string
	 * 
	 * @return string NotFound Controller String
	 */
	public function getNotFoundController() {
		return $this->_notFoundController;
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
	 * Public method to get the Default Action string
	 * 
	 * @return string Default Action String
	 */
	public function getDefaultAction() {
		return $this->_defaultAction;
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
		return $this->_dispatcher->dispatch($this->_registry);
	}
	
}

?>