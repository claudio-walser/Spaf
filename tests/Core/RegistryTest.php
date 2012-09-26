<?php
namespace Spaf\tests\Core;
 
class RegistryTest extends \PHPUnit_Framework_TestCase {
	
	protected $fixture;
	
	protected function setUp() {
		// set something globally up
	}
	
	public function testRegSomething() {
		$this->assertEquals(0, 0);
	}
	
	public function testRegSomethingElse() {
		$this->assertEquals(1, 1);
	}
	
	public function tearDown() {
		// tear something globally down
	}
	
}
?>