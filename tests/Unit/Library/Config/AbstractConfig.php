<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Config/AbstractConfig.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Config;

/**
 * \Spaf\tests\Unit\Library\Config\AbstractConfig
 *
 * The AbstractConfig class is a base class for any further config test.
 * But its not a test by itself
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Config
 * @namespace Spaf\tests\Unit\Library\Config
 */
abstract class AbstractConfig extends \Spaf\tests\Unit\TestCase {

	/**
	 * Config instance
	 *
	 * @var \Spaf\Library\Config\Manager
	 */
	protected $_config = null;

	/**
	 * Driver to call
	 */
	protected $_driver = 'ini';

	/**
	 * Filename for this config driver test
	 */
	protected $_filename = 'config.ini';

	/**
	 * Source File object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	 protected $_sourceFile = null;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$path = $this->_getTestPath() . '/Data/Config/';
		// instantiate file object
		$this->_sourceFile = new \Spaf\Library\Directory\File($path . $this->_filename);

		// instantiate config manager object and pass file and driver type
		$this->_config = new \Spaf\Library\Config\Manager();
		$this->_config->registerDriver($this->_driver);
		$this->_config->setSourceFile($this->_sourceFile);

		unset($path);
	}

	/**
	 * Abstract tests, cause they are the same for all drivers
	 */

	/**
	 * Test read a value
	 *
	 * @return void
	 */
	public function readValue() {
		$masterServer = $this->_config->memcache->master_server;

		$this->assertEquals(
			'cache01',
			$masterServer
		);

		unset($masterServer);
	}

	/**
	 * Test change a value
	 *
	 * @return void
	 */
 	public function changeValue() {
		$this->assertEquals(
			'cache01',
			$this->_config->memcache->master_server
		);

		$newValue = 'cache03';
		$this->_config->memcache->master_server = $newValue;

		$this->assertEquals(
			$newValue,
			$this->_config->memcache->master_server
		);

		unset($newValue);
	}

	/**
	 * Test set a new value in an existent section
	 *
	 * @return void
	 */
	public function setValueInExistentSection() {
		$this->assertEquals(
			null,
			$this->_config->memcache->dev_server
		);

		$newValue = 'cache-dev';
		$this->_config->memcache->dev_server = $newValue;

		$this->assertEquals(
			$newValue,
			$this->_config->memcache->dev_server
		);

		unset($newValue);
	}

	/**
	 * Test set a new value in a new section
	 *
	 * @return void
	 */
	public function setValueInNewSection() {
		$this->assertEquals(
			array(),
			$this->_config->newsection->toArray()
		);

		$this->_config->newsection->foo = 'bar';

		$this->assertEquals(
			array('foo' => 'bar'),
			$this->_config->newsection->toArray()
		);
	}

	/**
	 * Test set a new value in a new section and save
	 * everything as a new config file.
	 * Then create a new config manager object with this file
	 * and compare its content.
	 *
	 * @return void
	 */
	public function save() {
		// put a new section and save in a new file
		$this->_config->newsection->foo = 'bar';
		$fileCopy = new \Spaf\Library\Directory\File($this->_sourceFile->getPath() . $this->_filenameCopy, true);
		$this->_config->read();
		$this->_config->setSourceFile($fileCopy);
		$this->_config->write();

		// read completly from scratch
		$config = new \Spaf\Library\Config\Manager();
		$config->registerDriver($this->_driver);
		$config->setSourceFile($fileCopy);

		$this->assertEquals(
			array(
				// default ini content
				'memcache' => array(
					'master_server' => 'cache01',
					'slave_server' => 'cache02'
				),
				'types' => array(
					'boolean' => true,
					'null' => null,
					'string' => "some content with = equals and \"double qoutes\"",
					'integer' => 5,
					'signed' => -1,
					'float' => 7.1
				),

				// new section, filled in the begining of this test
				'newsection' => array(
					'foo' => 'bar'
				)
			),

			$config->toArray()
		);

		// delete the copy
		$fileCopy->delete();

		unset($filepathCopy);
		unset($file);
		unset($config);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	protected function tearDown() {
		unset($this->_config);
		unset($this->_driver);
		unset($this->_filename);
		unset($this->_sourceFile);
	}

}

?>