<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Core/Controller/IndexTest.php
 * @created Wed Oct 3 19:56:13 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Core\Controller;

/**
 * \Spaf\tests\Core\Controller\IndexTest
 *
 * The DispatcherTest class tests any aspect of \Spaf\Core\Controller\Index.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Core\Controller
 * @namespace Spaf\tests\Unit\Core\Controller
 */
class IndexTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * Current controller instance
	 *
	 * @var \Spaf\Core\Controller\Index
	 */
	private $_controller = null;

	/**
	 * Current dispatcher instance
	 *
	 * @var \Spaf\Core\Dispatcher
	 */
	private $_dispatcher = null;

	/**
	 * Mocked registry to pass
	 *
	 * @var \Spaf\tests\Mock\Core\Registry
	 */
	private $_registry = null;

	/**
	 * Setup some objects
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_registry = \Spaf\tests\Mock\Core\Registry::getInstance();
		$request = new \Spaf\Core\Request\Http();
		$response = new \Spaf\Core\Response\Php();
		$this->_registry->set('request', $request, true);
		$this->_registry->set('response', $response, true);
		// get normal registry first
		$this->_dispatcher = new \Spaf\Core\Dispatcher();
		$this->_dispatcher->setRegistry($this->_registry);

		$this->_controller = new \Spaf\Core\Controller\Index($this->_dispatcher);

		unset($request);
		unset($response);
	}

	/**
	 * Test the return value of the default view
	 *
	 * @return void
	 */
	public function testView() {
		$expectedData = array(
			'success' => true,
			'data' => 'default controllers listing method',
			'count' => 1
		);

		$data = $this->_controller->view();

		$this->assertEquals(
			$expectedData,
			$data
		);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_registry);
		unset($this->_controller);
	}
}

?>