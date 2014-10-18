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