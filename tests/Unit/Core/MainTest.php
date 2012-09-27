<?php

/**
 * $Id$
 *
 * Spaf/tests/Core/MainTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Core;

/**
 * \Spaf\tests\Core\MainTest
 *
 * The MainTest class tests any aspect of \Spaf\Core\Main.
 *
 * @author Claudio Walser
 * @package \Spaf\tests\Core
 * @namespace \Spaf\tests\Core
 */
class MainTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * The normal registry object
	 * 
	 * @var \Spaf\Core\Main
	 */
	private $_main = null;
	
	/**
	 * The registry mock-object
	 * 
	 * @var \Spaf\tests\Mock\Core\Registry
	 * /
	private $_mockObject = null;
	*/
	
	/**
	 * Setup both, normal and mock registry objects
	 * 
	 * @return void
	 */
	protected function setUp() {
		// get normal registry first
		$this->_main = new \Spaf\Core\Main();
	}
		
	/**
	 * Test getInstance intense.
	 * Means test it by normal registry object and test
	 * mock-object injection as well.
	 * 
	 * @return void
	 */
	public function testSomething() {
	}
	
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