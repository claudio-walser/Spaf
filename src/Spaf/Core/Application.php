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
	
	protected $_defaultType = 'php';
	protected $_types = array('php', 'json', 'xml');


	public function __construct($type = 'php') {
		$this->_type = in_array($type, $this->_types) ? $type : $this->_defaultType;
				
		switch ($this->_type) {
			case 'php':
				$response = new \Spaf\Core\Response\Php();
				$request = new \Spaf\Core\Request\Php();
				break;
			
			default:
				$response = new \Spaf\Core\Response\Json();
				$request = new \Spaf\Core\Request\Http();
				break;
		}

		$this->setRegistry(\Spaf\Core\Registry::getInstance());
		$this->setRequest($request);
		$this->setResponse($response);
	}

	public function run($controller = '\\DreamboxRecorder\\Controller\\NotFound', $action = 'view', $params = array()) {
		if ($this->_type === 'php') {
			// setup for http request
			$this->_request->setParam('controller', $controller);
			$this->_request->setParam('action', $action);
			
			if (!empty($params)) {
				foreach ($params as $key => $value) {
					$this->_request->setParam($key, $value);
				}
			}
		}
		// run application and return
		return parent::run();
	}
}

?>