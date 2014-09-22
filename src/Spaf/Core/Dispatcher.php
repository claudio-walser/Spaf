<?php

/**
 * $Id$
 *
 * Spaf/Core/Dispatcher.php
 * @created Tue Jun 08 19:26:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core;

/**
 * \Spaf\Core\Dispatcher
 *
 * The basic Dispatcher class
 * The Dispatcher is processing the request parameters
 * and calls the correct Controller class based on that.
 *
 * @author Claudio Walser
 * @package Spaf\Core
 * @namespace Spaf\Core
 */
class Dispatcher {

	/**
	 * The Registry Object.
	 *
	 * @var \Spaf\Core\Registry
	 */
	protected $_registry = null;

	protected $_request = null;
	protected $_response = null;


	/**
	 * The requested controller Object.
	 *
	 * @var \Spaf\Core\Controller\Abstraction
	 */
	protected $_controller = null;

	/**
	 * Name of the method which is to call.
	 *
	 * @var string
	 */
	protected $_action = null;

	/**
	 * Default controller if the requested one was not found.
	 *
	 * @var string
	 */
	protected $_notFoundController = '\\Spaf\\Core\\Controller\\NotFound';

	/**
	 * Default controller if no one is given.
	 *
	 * @var string
	 */
	protected $_defaultController = '\\Spaf\\Core\\Controller\\Index';

	/**
	 * Default action if no one is given,
	 * or the given one can not be found.
	 *
	 * @var string
	 */
	protected $_defaultAction = 'view';

	/**
	 * Set the registry object
	 *
	 * @param \Spaf\Core\Registry Registry object for injection
	 * @return boolean true
	 */
	public function setRegistry(\Spaf\Core\Registry $registry) {
	   $this->_registry = $registry;

	   return true;
	}

	/**
	 * Get the registry object
	 *
	 * @return \Spaf\Core\Registry Registry object for injection
	 */
	public function getRegistry() {
		return $this->_registry;
	}

	/**
	 * Set the property of the not found controller.
	 *
	 * @throws \Spaf\Core\Exception Throws an exception if you try to set an undefined controller
	 *
	 * @param string Name of the not-found controller
	 * @return boolean true
	 */
	public function setNotFoundController($controller) {
		if (!class_exists($controller)) {
			throw new Exception(get_class($this) . ': You try to set the inexistent not-found controller "' . $controller . '"');
		}
		$this->_notFoundController = (string) $controller;

		return true;
	}

	/**
	 * Returns the name of the current not found controller
	 *
	 * @return string Name of the current not found controller class
	 */
	public function getNotFoundController() {
		return $this->_notFoundController;
	}

	/**
	 * Set the property of the default container.
	 *
	 * @throws \Spaf\Core\Exception Throws an exception if you try to set an undefined controller
	 *
	 * @param string Name of the default controller
	 * @return boolean
	 */
	public function setDefaultController($controller) {
		if (!class_exists($controller)) {
			throw new Exception(get_class($this) . ': You try to set the inexistent default controller "' . $controller . '"');
		}
		$this->_defaultController = $controller;

		return true;
	}

	/**
	 * Returns the name of the current default controller
	 *
	 * @return string Name of the current default controller class
	 */
	public function getDefaultController() {
		return $this->_defaultController;
	}

	/**
	 * Set the property of the default controller action.
	 *
	 * @param string Name of the default action
	 * @return boolean
	 */
	public function setDefaultAction($action) {
		$this->_defaultAction = $action;

		return true;
	}

	/**
	 * Returns the name of the current default action
	 *
	 * @return string Name of the current default action method
	 */
	public function getDefaultAction() {
		return $this->_defaultAction;
	}

	public function setResponse(\Spaf\Core\Response\Abstraction $response) {
	   $this->_response = $response;

	   return true;
	}

	public function setRequest(\Spaf\Core\Request\Abstraction $request) {
	   $this->_request = $request;

	   return true;
	}

	public function getRequest() {
		return $this->_request;
	}

	public function getResponse() {
		return $this->_response;
	}

	/**
	 * Execute the dispatcher based on the given request
	 * parameters. This method is handling not found fallbacks as well.
	 *
	 * @throws \Spaf\Core\Exception Throws an Exception if no request object is set in the registry yet
	 *
	 * @return mixed The controllers return values
	 */
	public function dispatch() {
		// get registry/request object, throws an exception if none is set yet.
		//$request = $this->_registry->get('request', true);

		// get controller
		$this->_controller = $this->_request->getParam('controller', $this->_defaultController);


		// if unknown controller
		if (!class_exists($this->_controller)) {
			$controller = new $this->_notFoundController($this);
			return $controller->view();
		}


		// instantiate controller
		$controller = new $this->_controller($this);

		// get action
		$this->_action = $this->_request->getParam('action', $this->_defaultAction);
		// check first and set defaultAction as action
		if (!method_exists($controller, $this->_action)) {
			$this->_action = $this->_defaultAction;
		}

		// check if method still does not exist
		if (!method_exists($controller, $this->_action)) {
			// instantiate the default controller
			$controller = new $this->_notFoundController($this);
			return $controller->{$this->_defaultAction}($this->_controller, $this->_defaultAction);
		}

		// forward the controllers return value
 		return $this->_doDispatch($controller, $this->_action);
	}

	/**
	 * Execute the controller
	 *
	 * Execute the given action on the given controller
	 * and return its return values.
	 *
	 * @param \Spaf\Core\Controller\Abstraction Controller object
	 * @param string Action to call on this controller
	 * @return mixed the controllers return value
	 */
	protected function _doDispatch(\Spaf\Core\Controller\Abstraction $controller, $action) {
		// forward the controllers return value
		return $controller->{$action}();
	}

}

?>