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
	 * Application object
	 *
	 * @var \Spaf\Core\Application
	 */
	private $_application = null;

	/**
	 * Setup both, normal and mock registry objects
	 *
	 * @return void
	 */
	protected function setUp() {
		// get normal registry first
		$this->_application = new \Spaf\Core\Application('php');
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
			$this->_application->getDefaultController()
		);

		// assert notFoundController
		$this->assertEquals(
			$notFoundController,
			$this->_application->getNotFoundController()
		);

		// assert defaultAction
		$this->assertEquals(
			$defaultAction,
			$this->_application->getDefaultAction()
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
	public function testSetGetRegistry() {
		// default should be \Spaf\Core\Registry, check on that first
		$origRegistry = \Spaf\Core\Registry::getInstance();

		// assert original registry
		$this->assertEquals(
			$origRegistry,
			$this->_application->getRegistry()
		);

		// get and set new registry
		$registry = \Spaf\tests\Mock\Core\Registry::getInstance();
		$this->_application->setRegistry($registry);

		// assert new registry
		$this->assertEquals(
			$registry,
			$this->_application->getRegistry()
		);

		unset($registry);
		unset($origRegistry);		
	}

	/**
	 * Tests the methods to set and get a defaultController class
	 *
	 * @return void
	 */
	public function testSetGetDefaultController() {
		$controllerName = '\\Spaf\\tests\\Mock\\Core\\Controller\\Index';
		$this->_application->setDefaultController($controllerName);
		$this->assertEquals(
			$controllerName,
			$this->_application->getDefaultController()
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
		$this->_application->setNotFoundController($controllerName);
		$this->assertEquals(
			$controllerName,
			$this->_application->getNotFoundController()
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
		$this->_application->setDefaultAction($methodName);
		$this->assertEquals(
			$methodName,
			$this->_application->getDefaultAction()
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

		$this->_application->setRegistry($registry);
		$this->_application->dispatch();

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
		$this->_application->setNotFoundController('\\This\\Is\\A\\Non\Existent\\Classname');
	}

	/**
	 * Test all exceptions this class can throw
	 *
	 * @return void
	 */
	public function testDefaultControllerException() {
		// try to set an inexistent notFound Controller Class
		$this->setExpectedException('\\Spaf\\Core\\Exception');
		$this->_application->setDefaultController('\\This\\Is\\A\\Non\Existent\\Classname');
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_application);
	}

}

?>