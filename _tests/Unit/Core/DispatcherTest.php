<?php

/**
 * $Id$
 *
 * Spaf/_tests/Core/DispatcherTest.php
 * @created Wed Oct 3 19:56:13 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Core;

/**
 * \Spaf\_tests\Core\DispatcherTest
 *
 * The DispatcherTest class tests any aspect of \Spaf\Core\Dispatcher.
 *
 * @author Claudio Walser
 * @package \Spaf\_tests\Core
 * @namespace \Spaf\_tests\Core
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase {

	/**
	 * The normal registry object
	 *
	 * @var \Spaf\Core\Registry
	 */
	private $_dispatcher = null;

	/**
	 * Setup both, normal and mock registry objects
	 *
	 * @return void
	 */
	protected function setUp() {
		// get normal registry first
		$this->_dispatcher = new \Spaf\Core\Dispatcher();
	}

	/**
	 * Test the default values of \Spaf\Core\Dispatcher.
	 */
	public function testDefaultProperties() {
		$defaultController = '\\Spaf\\Core\\Controller\\Index';
		$notFoundController = '\\Spaf\\Core\\Controller\\NotFound';
		$defaultAction = 'view';
		// assert defaultController
		$this->assertEquals(
			$defaultController,
			$this->_dispatcher->getDefaultController()
		);

		// assert notFoundController
		$this->assertEquals(
			$notFoundController,
			$this->_dispatcher->getNotFoundController()
		);

		// assert defaultAction
		$this->assertEquals(
			$defaultAction,
			$this->_dispatcher->getDefaultAction()
		);

		unset($defaultController);
		unset($notFoundController);
	}

	/**
	 * Test to set a registry object and compare
	 * the return value of getRegistry with your given object.
	 */
	public function setGetRegistry() {
		$registry = \Spaf\_tests\Mock\Core\Registry::getInstance();

		$this->_dispatcher->setRegistry($registry);

		// assert registry
		$this->assertEquals(
			$registry,
			$this->_dispatcher->getRegistry()
		);

		unset($registry);
	}

	/**
	 * Tests the methods to set and get a defaultController class
	 */
	public function testSetGetDefaultController() {
		$controllerName = '\\Spaf\\_tests\\Mock\\Core\\Controller\\Index';
		$this->_dispatcher->setDefaultController($controllerName);
		$this->assertEquals(
			$controllerName,
			$this->_dispatcher->getDefaultController()
		);
		//setNotFoundController
	}

	/**
	 * Tests the methods to set and get a notFoundController class
	 */
	public function testSetGetNotFoundController() {
		$controllerName = '\\Spaf\\_tests\\Mock\\Core\\Controller\\NotFound';
		$this->_dispatcher->setNotFoundController($controllerName);
		$this->assertEquals(
			$controllerName,
			$this->_dispatcher->getNotFoundController()
		);
		//setNotFoundController
	}

	/**
	 * Tests the methods to set and get a notFoundController class
	 */
	public function testSetGetDefaultAction() {
		$methodName = 'viewMock';
		$this->_dispatcher->setDefaultAction($methodName);
		$this->assertEquals(
			$methodName,
			$this->_dispatcher->getDefaultAction()
		);
	}

	/**
	 * Test the dispatch method itself.
	 * @TODO this one has to be implemented
	 */
	public function testDispatch() {
		return;
		$registry = \Spaf\_tests\Mock\Core\Registry::getInstance();
		// at home i should have them
		$request = new \Spaf\_tests\Mock\Core\Request\Http();
		$response = new \Spaf\_tests\Mock\Core\Response\Php();
		$registry->set('request', $request, true);
		$registry->set('response', $response, true);

		$this->_dispatcher->setRegistry($registry);
		$this->_dispatcher->dispatch();

		unset($registry);
		unset($request);
		unset($response);
	}

	/**
	 * Test all exceptions this class can throw
	 */
	public function testNotFoundControllerException() {
		// try to set an inexistent notFound Controller Class
		$this->setExpectedException('\\Spaf\\Core\\Exception');
		$this->_dispatcher->setNotFoundController('\\This\\Is\\A\\Non\Existent\\Classname');
	}

	/**
	 * Test all exceptions this class can throw
	 */
	public function testDefaultControllerException() {
		// try to set an inexistent notFound Controller Class
		$this->setExpectedException('\\Spaf\\Core\\Exception');
		$this->_dispatcher->setDefaultController('\\This\\Is\\A\\Non\Existent\\Classname');
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_dispatcher);
	}

}

?>