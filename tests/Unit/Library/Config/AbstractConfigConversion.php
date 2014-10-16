<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Config/Conversion.php
 * @created Sat Oct 13 21:49:41 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Config;

/**
 * \Spaf\tests\Unit\Library\Config\ConversionTest
 *
 * The base Conversion class for testing config-file conversion.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Config
 * @namespace Spaf\tests\Unit\Library\Config
 */
abstract class AbstractConfigConversion extends \Spaf\tests\Unit\TestCase {

	/**
	 * Ini file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_fileIni = null;

	/**
	 * Filename for the ini
	 *
	 * @var string
	 */
	protected $_filenameIni = 'config.ini';

	/**
	 * Filename of the ini copy
	 *
	 * @var string
	 */
	protected $_filenameIniCopy = 'config-conversion.ini';

	/**
	 * Json file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_fileJson = null;

	/**
	 * Filename for the json
	 *
	 * @var string
	 */
	protected $_filenameJson = 'config.json';

	/**
	 * Filename of the json copy
	 *
	 * @var string
	 */
	protected $_filenameJsonCopy = 'config-conversion.json';

	/**
	 * Php file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_filePhp = null;

	/**
	 * Filename for the ini
	 *
	 * @var string
	 */
	protected $_filenamePhp = 'config.php';

	/**
	 * Filename of the ini copy
	 *
	 * @var string
	 */
	protected $_filenamePhpCopy = 'config-conversion.php';

	/**
	 * Srz file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_fileSrz = null;

	/**
	 * Filename for the srz
	 *
	 * @var string
	 */
	protected $_filenameSrz = 'config.srz';

	/**
	 * Filename of the srz copy
	 *
	 * @var string
	 */
	protected $_filenameSrzCopy = 'config-conversion.srz';

	/**
	 * Xml file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_fileXml = null;

	/**
	 * Filename for the xml
	 *
	 * @var string
	 */
	protected $_filenameXml = 'config.xml';

	/**
	 * Filename of the xml copy
	 *
	 * @var string
	 */
	protected $_filenameXmlCopy = 'config-conversion.xml';

	/**
	 * Config Object
	 *
	 * @var \Spaf\Library\Config\Manager
	 */
	protected $_mainConfig = null;

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
		$path = $this->_getTestPath() . '/Data/Config/';

		$this->_fileIni = new \Spaf\Library\Directory\File($path . $this->_filenameIni);
		$this->_fileJson = new \Spaf\Library\Directory\File($path . $this->_filenameJson);
		$this->_filePhp = new \Spaf\Library\Directory\File($path . $this->_filenamePhp);
		$this->_fileSrz = new \Spaf\Library\Directory\File($path . $this->_filenameSrz);
		$this->_fileXml = new \Spaf\Library\Directory\File($path . $this->_filenameXml);


		$this->_mainConfig = new \Spaf\Library\Config\Manager();
		$this->_mainConfig->registerDriver($this->_mainDriver);
	}

	/**
	 * Tear down
	 *
	 * @return void
	 */
	protected function tearDown() {
		unset($this->_mainConfig);
		unset($this->_fileIni);
		unset($this->_fileJson);
		unset($this->_filePhp);
		unset($this->_fileSrz);
		unset($this->_fileXml);
	}

}

?>