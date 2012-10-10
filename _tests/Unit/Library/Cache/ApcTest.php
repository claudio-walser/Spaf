<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Cache/ApcTest.php
 * @created Wed Oct 10 18:57:56 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Cache;

/**
 * \Spaf\_tests\Unit\Library\Cache\ApcTest
 *
 * The ApcTest class tests any aspect of \Spaf\Library\Cache\Apc.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Cache
 * @namespace Spaf\_tests\Unit\Library\Cache
 */
class ApcTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Apc instance
	 *
	 * @var \Spaf\Library\Cache\Apc
	 */
	private $_apc = null;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_apc = \Spaf\Library\Cache\Manager::factory('apc');
	}

	public function testAdd() {
		$this->assertTrue(true);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {

	}

}

?>