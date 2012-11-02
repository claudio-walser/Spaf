<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Config/IniConversionTest.php
 * @created Sat Oct 13 21:49:41 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Config;

/**
 * \Spaf\_tests\Unit\Library\Config\IniTest
 *
 * The IniConversionTest class tests any aspect of \Spaf\Library\Config\Driver\Ini conversion.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Config
 * @namespace Spaf\_tests\Unit\Library\Config
 */
class IniConversionTest extends Conversion {

	/**
	 * Main driver type for the current implementation
	 *
	 * @var string
	 */
	protected $_mainDriver = 'ini';


	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		parent::setUp();
		$this->_mainConfig->setSourceFile($this->_fileIni);
		$this->_mainConfig->read();
	}

	/**
	 * Test conversion to a Json Copy and compare the content with the original Json config file
	 *
	 * @return void
	 */
	public function testToJson() {
		$conversionFile = new \Spaf\Library\Directory\File($this->_fileIni->getPath() . $this->_filenameJsonCopy, true);
		$this->_mainConfig->registerDriver('json');
		$this->_mainConfig->setSourceFile($conversionFile);
		$this->_mainConfig->save();

		// assert contents of conversion and origianl xml config
		$this->assertEquals(
			$this->_fileJson->getLines(),
			$conversionFile->getLines()
		);

		// clean up
		$conversionFile->delete();
		unset($conversionFile);
	}

	/**
	 * Test conversion to a Php Copy and compare the content with the original Php config file
	 *
	 * @return void
	 */
	public function testToPhp() {
		$conversionFile = new \Spaf\Library\Directory\File($this->_fileIni->getPath() . $this->_filenamePhpCopy, true);
		$this->_mainConfig->registerDriver('php');
		$this->_mainConfig->setSourceFile($conversionFile);
		$this->_mainConfig->save();

		// assert contents of conversion and origianl xml config
		$this->assertEquals(
			$this->_filePhp->getLines(),
			$conversionFile->getLines()
		);

		// clean up
		$conversionFile->delete();
		unset($conversionFile);
	}

	/**
	 * Test conversion to a Srz Copy and compare the content with the original Srz config file
	 *
	 * @return void
	 */
	public function testToSerialized() {
		$conversionFile = new \Spaf\Library\Directory\File($this->_fileIni->getPath() . $this->_filenameSrzCopy, true);
		$this->_mainConfig->registerDriver('srz');
		$this->_mainConfig->setSourceFile($conversionFile);
		$this->_mainConfig->save();

		// assert contents of conversion and origianl xml config
		$this->assertEquals(
			$this->_fileSrz->getLines(),
			$conversionFile->getLines()
		);

		// clean up
		$conversionFile->delete();
		unset($conversionFile);
	}

	/**
	 * Test conversion to an XML Copy and compare the content with the original XML config file
	 *
	 * @return void
	 */
	public function testToXml() {
		$conversionFile = new \Spaf\Library\Directory\File($this->_fileIni->getPath() . $this->_filenameXmlCopy, true);
		$this->_mainConfig->registerDriver('xml');
		$this->_mainConfig->setSourceFile($conversionFile);
		$this->_mainConfig->save();

		// assert contents of conversion and origianl xml config
		$this->assertEquals(
			$this->_fileXml->getLines(),
			$conversionFile->getLines()
		);

		// clean up
		$conversionFile->delete();
		unset($conversionFile);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	protected function tearDown() {
		parent::tearDown();
	}

}

?>