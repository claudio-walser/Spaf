<?php
/**
 * $Id$
 * Main Dispatcher class
 *
 * @created 	Tue Jun 08 19:26:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Cwa\Core
 * @namespace	\Cwa\Core
 */

namespace Cwa\Core;

/**
 * \Cwa\Core\Dispatcher
 *
 * The basic Dispatcher class
 * The Dispatcher process the request parameters
 * and call the correct Controller class based on that.
 *
 * @author 		Claudio Walser
 */
class Dispatcher {

	/**
	 * The requested controller Object.
	 *
	 * @var		\Cwa\Core\Controller
	 */
	protected $_controller = null;

	/**
	 * Name of the method which is to call.
	 *
	 * @var		string
	 */
	protected $_action = null;

	/**
	 * Default controller if the requested one was not found.
	 *
	 * @var		string
	 */
	protected $_notFoundController = '\\Cwa\\Core\\Controller\\NotFound';

	/**
	 * Default controller if no one is given.
	 *
	 * @var		string
	 */
	protected $_defaultController = '\\Cwa\\Core\\Controller\\Index';

	/**
	 * Default action if no one is given,
	 * or the given one can not be found.
	 *
	 * @var		string
	 */
	protected $_defaultAction = 'view';

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
	 * set the default controller
	 *
	 * Change the property of the default container.
	 *
	 * @param	string		the default controller
	 * @return	boolean
	 */
	public function setDefaultController($controller) {
		$this->_defaultController = $controller;
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
		$this->_defaultAction = $action;
		return true;
	}


	/**
	 * Check all parameters in order to run the controller
	 *
	 * Execute the dispatcher based on the given request 
	 * parameters.
	 *
	 * @return	mixed		the controllers return values
	 */
	public function dispatch() {
		// get registry/request objects
		$registry = Registry::getInstance();
		$request = $registry->get('request');

		// get controller
		$this->_controller = $request->getParam('controller', $this->_defaultController);
		
		// if unknown controller
		if (!class_exists($this->_controller)) {
			$controller = new $this->_notFoundController();
			return $controller->controllerNotFound($this->_controller);
		}

		// instantiate controller
		$controller = new $this->_controller();

		// get action
		$this->_action = $request->getParam('action', $this->_defaultAction);

		// check if method does not exists
		if (!method_exists($controller, $this->_action)) {
			$controller = new $this->_notFoundController();
			return $controller->methodNotFound($this->_controller, $this->_action);
		}

		return $this->_doDispatch($controller);
	}

	/**
	 * Execute the controller
	 *
	 * Execute the given action on the given controller
	 * and return its return values.
	 *
	 * @return	mixed		the controllers return values
	 */
	protected function _doDispatch(Controller\AbstractController $controller) {
		return $controller->{$this->_action}();
	}



}

?>