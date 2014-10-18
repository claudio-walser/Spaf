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
 * \Spaf\tests\Unit\Core\Controller\IndexTest
 *
 * The DispatcherTest class tests any aspect of \Spaf\Core\Controller\Index.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Core\Controller
 * @namespace Spaf\tests\Unit\Core\Controller
 */
class NotFoundTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * Current controller instance
	 *
	 * @var \Spaf\Core\Controller\NotFound
	 */
	private $_controller = null;

	/**
	 * Current application instance
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
		// get dispatcher
		$this->_application = new \Spaf\Core\Application('php');
		$this->_controller = new \Spaf\Core\Controller\NotFound($this->_application);		
	}

	/**
	 * Test the return value of the not-found view
	 *
	 * @return void
	 */
	public function testView() {
		$expectedData = array(
			'success' => true,
			'data' => 'notFound controllers listing method',
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