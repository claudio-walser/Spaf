<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Core/DispatcherTest.php
 * @created Wed Oct 3 19:56:13 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Core;

/**
 * \Spaf\tests\Unit\Core\DispatcherTest
 *
 * The DispatcherTest class tests any aspect of \Spaf\Core\Dispatcher.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Core
 * @namespace Spaf\tests\Unit\Core
 */
class DispatcherTest extends \Spaf\tests\Unit\TestCase {

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
	 *
	 * @return void
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
	 *
	 * @return void
	 */
	public function setGetRegistry() {
		$registry = \Spaf\tests\Mock\Core\Registry::getInstance();

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
	 *
	 * @return void
	 */
	public function testSetGetDefaultController() {
		$controllerName = '\\Spaf\\tests\\Mock\\Core\\Controller\\Index';
		$this->_dispatcher->setDefaultController($controllerName);
		$this->assertEquals(
			$controllerName,
			$this->_dispatcher->getDefaultController()
		);
		//setNotFoundController
	}

	/**
	 * Tests the methods to set and get a notFoundController class
	 *
	 * @return void
	 */
	public function testSetGetNotFoundController() {
		$controllerName = '\\Spaf\\tests\\Mock\\Core\\Controller\\NotFound';
		$this->_dispatcher->setNotFoundController($controllerName);
		$this->assertEquals(
			$controllerName,
			$this->_dispatcher->getNotFoundController()
		);
		//setNotFoundController
	}

	/**
	 * Tests the methods to set and get a notFoundController class
	 *
	 * @return void
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
	 *
	 * @TODO this one has to be implemented
	 * @return void
	 */
	public function testDispatch() {
		return;
		$registry = \Spaf\tests\Mock\Core\Registry::getInstance();
		// at home i should have them
		$request = new \Spaf\tests\Mock\Core\Request\Http();
		$response = new \Spaf\tests\Mock\Core\Response\Php();
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
	 *
	 * @return void
	 */
	public function testNotFoundControllerException() {
		// try to set an inexistent notFound Controller Class
		$this->setExpectedException('\\Spaf\\Core\\Exception');
		$this->_dispatcher->setNotFoundController('\\This\\Is\\A\\Non\Existent\\Classname');
	}

	/**
	 * Test all exceptions this class can throw
	 *
	 * @return void
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