<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Core/ApplicationTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Core;

/**
 * \Spaf\tests\Unit\Core\ApplicationTest
 *
 * The ApplicationTest class tests any aspect of \Spaf\Core\Application.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Core
 * @namespace Spaf\tests\Unit\Core
 */
class ApplicationTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * The normal Application object
	 *
	 * @var \Spaf\Core\Application
	 */
	private $_application = null;

	/**
	 * The normal request object
	 *
	 * @var \Spaf\Core\Request\AbstractRequest
	 */
	private $_request = null;

	/**
	 * The normal response object
	 *
	 * @var \Spaf\Core\Response\AbstractResponse
	 */
	private $_response = null;

	/**
	 * Setup both, normal and mock registry objects
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_application = new \Spaf\Core\Application();
		$this->_request = new \Spaf\tests\Mock\Core\Request\Http();
		$this->_response = new \Spaf\tests\Mock\Core\Response\Json();
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
			$this->_application->getRegistry()
		);

		// now inject a mocked registry
		$registry = \Spaf\tests\Mock\Core\Registry::getInstance();
		$this->_application->setRegistry($registry);

		$this->assertEquals(
			$registry,
			$this->_application->getRegistry()
		);

		// check dispatcher and application registry is the same
		$dispatcher = $this->_application->getDispatcher();
		$this->assertEquals(
			$dispatcher->getRegistry(),
			$this->_application->getRegistry()
		);



		// is this functionality really needed? Shouldnt it just always update
		// its dispatcher as well?
		// Updating the registry without updating the dispatcher
		// might just cause some errors. Is it usefull for anything?

		// put another registry again, but do not update the dispatcher
		$this->_application->setRegistry($origRegistry, false);
		$this->assertNotEquals(
			$dispatcher->getRegistry(),
			$this->_application->getRegistry()
		);

		$this->_application->setRegistry($origRegistry, true);
		$this->assertEquals(
			$dispatcher->getRegistry(),
			$this->_application->getRegistry()
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
			get_class($this->_application->getDispatcher())
		);


		// now inject a mocked dispatcher
		$dispatcher = new \Spaf\tests\Mock\Core\Dispatcher();
		$this->_application->setDispatcher($dispatcher);

		$this->assertEquals(
			$dispatcher,
			$this->_application->getDispatcher()
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
	   $this->_application->setRequest($this->_request);

		$this->assertEquals(
			$this->_request,
			$this->_application->getRequest()
		);
	}

   /**
	 * Test setRequest and getRequest.
	 * Means test it by normal request object.
	 *
	 * @return void
	  */
	public function testSetGetResponse() {
		$this->_application->setResponse($this->_response);

		$this->assertEquals(
			$this->_response,
			$this->_application->getResponse()
		);

	}

	/**
	 * Test setRequest and getRequest.
	 * Means test it by normal request object.
	 *
	 * @todo Implement with mock objects not sending any headers
	 * @return void
	  */
	/*public function testSetGetResponse() {
		$response = new \Spaf\Core\Response\Json();

		$this->_application->setResponse($response);

		$this->assertEquals(
			$response,
			$this->_application->getResponse()
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
		unset($this->_application);
		unset($this->_mockObject);
	}

}

?>