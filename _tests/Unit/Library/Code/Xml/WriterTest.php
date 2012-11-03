<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Code/Xnk/WriterTest.php
 * @created Sat Oct 03 3:31:44 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Code\Xml;

/**
 * \Spaf\_tests\Unit\Library\Code\Xml\WriterTest
 *
 * The WriterTest class tests any aspect of \Spaf\Library\Code\Xml\Writer.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Config
 * @namespace Spaf\_tests\Unit\Library\Config
 */
class WriterTest extends \Spaf\_tests\Unit\TestCase {

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
	}

	public function testWrite() {
		$document = new \Spaf\Library\Code\Xml\Document();

		$rootNode = new \Spaf\Library\Code\Xml\Node('config');
		$rootNode->addAttribute('foo', 'bar');
		$document->setRootNode($rootNode);

		$memcache = new \Spaf\Library\Code\Xml\Node('memcache');
		$rootNode->addChild($memcache);

		$masterServer = new \Spaf\Library\Code\Xml\Node('master_server');
		$masterServer->setValue('cache01');
		$memcache->addChild($masterServer);

		$slaveServer = new \Spaf\Library\Code\Xml\Node('slave_server');
		$slaveServer->setValue('cache02');
		$memcache->addChild($slaveServer);


		$writer = new \Spaf\Library\Code\Xml\Writer();
		$writer->setDocument($document);

		//echo $writer;

		$this->assertTrue(true);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	protected function tearDown() {
	}

}

?>