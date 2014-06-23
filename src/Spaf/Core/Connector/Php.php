<?php

namespace Spaf\Core\Connector;

// connector to the backend for plain php projects on the same server
// with no need for a network connection
// dont like the naming yet but its for connecting the backend in php :p 
class Php {
	
	/**
	 * Response object
	 *
	 * @var \Spaf\Core\Response\AbstractResponse
	 */
	private $_response = null;
	
	/**
	 * Request object
	 *
	 * @var \Spaf\Core\Request\AbstractRequest
	 */
	private $_request = null;

	/**
	 * Business object
	 *
	 * @var \Spaf\Core\Business
	 */
	private $_business = null;
	
	/**
	 * Constructor instantiates all required objects
	 */
	public function __construct() {
		// request and response objects
		$this->_request = new \Spaf\Core\Request\Php();
		$this->_response = new \Spaf\Core\Response\Php();
		
		// instantiate business tier with a php request and response
		$this->_business = new \Spaf\Core\Application();
		$this->_business->setRequest($this->_request);
		$this->_business->setResponse($this->_response);
	}
	
	/**
	 * runs the required controller method with the given params
	 * 
	 * @param string Controller name (includes the namespace)
	 * @param string Name of the Action-Method
	 * @param array Array of params (key value pair)
	 * @return array Array with a success and data node in it. Some controllers might send the total amount back
	 */
	public function run($controller, $action, $params = array()) {
		// set controller and action
		$this->_request->set('controller', $controller);
		$this->_request->set('action', $action);
		
		// set specific controller params
		if (is_array($params)) {
			foreach($params as $key => $value) {
				$this->_request->set($key, $value);
			}
		}
		// execute and get controllers return
		$return = $this->_business->run();
		// reset the request
		$this->_request->reset();
		// return the data
		return $return;
	}
}
?>