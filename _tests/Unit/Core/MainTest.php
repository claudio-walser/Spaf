<?php

/**
 * $Id$
 *
 * Spaf/_tests/Core/MainTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Core;

/**
 * \Spaf\_tests\Core\MainTest
 *
 * The MainTest class tests any aspect of \Spaf\Core\Main.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Core
 * @namespace Spaf\_tests\Core
 */
class MainTest extends \PHPUnit_Framework_TestCase {

	/**
	 * The normal Main object
	 *
	 * @var \Spaf\Core\Main
	 */
	private $_main = null;

	/**
	 * The normal request object
	 *
	 * @var \Spaf\Core\Request\Abstraction
	 */
	private $_request = null;

	/**
	 * The normal response object
	 *
	 * @var \Spaf\Core\Response\Abstraction
	 */
	private $_response = null;

	/**
	 * Setup both, normal and mock registry objects
	 *
	 * @return void
	 */
	protected function setUp() {
		// get normal registry first
		$this->_main = new \Spaf\Core\Main();
		$this->_request = new \Spaf\_tests\Mock\Core\Request\Http();
		$this->_response = new \Spaf\_tests\Mock\Core\Response\Json();
	}

	/**
	 * Test setRegistry and getRegistry.
	 * Means test it by normal registry object and test
	 * mock-object injection as well.
	 *
	 * @return void
	 */
	public function testSetGetRegistry() {
		// default should be \Spaf\Core\Registry, check on that first
		$origRegistry = \Spaf\Core\Registry::getInstance();

		$this->assertEquals(
			$origRegistry,
			$this->_main->getRegistry()
		);

		// now inject a mocked registry
		$registry = \Spaf\_tests\Mock\Core\Registry::getInstance();
		$this->_main->setRegistry($registry);

		$this->assertEquals(
			$registry,
			$this->_main->getRegistry()
		);

		// check dispatcher and main registry is the same
		$dispatcher = $this->_main->getDispatcher();
		$this->assertEquals(
			$dispatcher->getRegistry(),
			$this->_main->getRegistry()
		);



		// is this functionality really needed? Shouldnt it just always update
		// its dispatcher as well?
		// Updating the registry without updating the dispatcher
		// might just cause some errors. Is it usefull for anything?

		// put another registry again, but do not update the dispatcher
		$this->_main->setRegistry($origRegistry, false);
		$this->assertNotEquals(
			$dispatcher->getRegistry(),
			$this->_main->getRegistry()
		);

		$this->_main->setRegistry($origRegistry, true);
		$this->assertEquals(
			$dispatcher->getRegistry(),
			$this->_main->getRegistry()
		);

		unset($registry);
	}

	/**
	 * Test setDispatcher and getDispatcher.
	 * Means test it by normal registry object and test
	 * mock-object injection as well.
	 *
	 * @return void
	 */
	public function testSetGetDispatcher() {
		// default should be \Spaf\Core\Dispatcher, check on that first
		$dispatcher = new \Spaf\Core\Dispatcher();
		// objects arent the same, since we instantiate a new Dispatcher above
		// but its okay if the are from the same class
		$this->assertEquals(
			get_class($dispatcher),
			get_class($this->_main->getDispatcher())
		);


		// now inject a mocked dispatcher
		$dispatcher = new \Spaf\_tests\Mock\Core\Dispatcher();
		$this->_main->setDispatcher($dispatcher);

		$this->assertEquals(
			$dispatcher,
			$this->_main->getDispatcher()
		);

		unset($dispatcher);
	}

	/**
	 * Test setRequest and getRequest.
	 * Means test it by normal request object.
	 *
	 * @return void
	  */
	public function testSetGetRequest() {
	   $this->_main->setRequest($this->_request);

		$this->assertEquals(
			$this->_request,
			$this->_main->getRequest()
		);
	}

   /**
	 * Test setRequest and getRequest.
	 * Means test it by normal request object.
	 *
	 * @return void
	  */
	public function testSetGetResponse() {
		$this->_main->setResponse($this->_response);

		$this->assertEquals(
			$this->_response,
			$this->_main->getResponse()
		);

	}

	/**
	 * Test setRequest and getRequest.
	 * Means test it by normal request object.
	 *
	 * @return void
	  */
	/*public function testSetGetResponse() {
		$response = new \Spaf\Core\Response\Json();

		$this->_main->setResponse($response);

		$this->assertEquals(
			$response,
			$this->_main->getResponse()
		);

	}
	*/

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_main);
		unset($this->_mockObject);
	}

}

?>