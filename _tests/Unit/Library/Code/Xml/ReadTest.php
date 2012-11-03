<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Code/Xnk/ReadTest.php
 * @created Sat Oct 03 13:33:27 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Code\Xml;

/**
 * \Spaf\_tests\Unit\Library\Code\Xml\ReadTest
 *
 * The ReadTest class tests any aspect of \Spaf\Library\Code\Xml\*.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Config
 * @namespace Spaf\_tests\Unit\Library\Config
 */
class ReadTest extends \Spaf\_tests\Unit\TestCase {

	private $_sourceContentXml = '<?xml version="1.0" encoding="UTF-8"?>

<config foo="bar">
	<memcache>
		<master_server>
			cache01
		</master_server>
		<slave_server>
			cache02
		</slave_server>
	</memcache>
</config>
';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
	}

	public function testDocument() {
		// created normall
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

		// from string
		$testDocument = new \Spaf\Library\Code\Xml\Document();
		$testDocument->fromString($this->_sourceContentXml);

		// assert both are the same
		$this->assertEquals(
			$document,
			$testDocument
		);

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