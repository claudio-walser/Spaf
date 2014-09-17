<?php

/**
 * $Id$
 *
 * Spaf/Library/Config/Manager.php
 * @created Sat Sep 09 08:17:23 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config;

/**
 * \Spaf\Library\Config\Manager
 *
 * Unified interface for different types of config files.
 * Currently supported are: ini, xml, json, php (simple array) and a simple serialized format
 *
 * @author Claudio Walser
 * @package Spaf\Library\Config
 * @namespace Spaf\Library\Config
 */
class Manager {

	/**
	 * The driver object
	 *
	 * @var \Spaf\Library\Config\Driver\Abstraction
	 */
	private $_driver = null;

	/**
	 * Default driver to choose.
	 *
	 * @var string
	 */
	private $_default = '\Spaf\Library\Config\Driver\Ini';

	/**
	 * Current config file.
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	private $_configFile = null;

	/**
	 * Data store for the config array.
	 *
	 * @var array
	 */
	private $_storedData = null;

	/**
	 * Creates a config object for ya
	 *
	 * @param mixed String with the driver type or driver object itself
	 * @return boolean True
	 */
	public static function factory($file) {
		$file = new \Spaf\Library\Directory\File($file);
		$config = new \Spaf\Library\Config\Manager();
		$config->registerDriver(strtolower($file->getEnding()));
		$config->setSourceFile($file);

		return $config;
	}

	/**
	 * Register one of the driver type.
	 * Currently supported is ini, xml, json, php (simple array) and serialized||srz (a simple serialized format)
	 *
	 * @param mixed String with the driver type or driver object itself
	 * @return boolean True
	 */
	public function registerDriver($driver) {
		// if its a driver object
		if ($driver instanceof \Spaf\Library\Config\Driver\Abstraction) {
			$this->_driver = $driver;

			return true;
		}

		// if its just a string (driver type)
		switch (strtolower($driver)) {
			case 'ini':
				$this->_driver = new \Spaf\Library\Config\Driver\Ini();
				break;

			case 'xml':
				$this->_driver = new \Spaf\Library\Config\Driver\Xml();
				break;

			case 'php':
				$this->_driver = new \Spaf\Library\Config\Driver\Php();
				break;

			case 'json':
				$this->_driver = new \Spaf\Library\Config\Driver\Json();
				break;

			case 'serialized':
			case 'srz':
				$this->_driver = new \Spaf\Library\Config\Driver\Serialized();
				break;

			default:
				$this->_driver = new $this->_default;
				break;
		}

		return true;
	}

	/**
	 * Set the source file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean True
	 */
	public function setSourceFile(\Spaf\Library\Directory\File $file) {
		return $this->_driver->setSourceFile($file);
	}

	/**
	 * Read and also parse a config file.
	 *
	 * @throws \Spaf\Library\Config\Exception Throws an exception if no driver set yet
	 * @return boolean True
	 */
	public function read() {
		if ($this->_driver === null) {
			throw new Exception('Initialize a driver first');
		}

		if ($this->_storedData === null) {
			$this->_storedData = array();
		}

		$data = $this->_driver->read();
		foreach ($data as $key => $data) {
			$this->_storedData[$key] = new Section($data);
		}

		return true;
	}

	/**
	 * Return the whole current config as array
	 *
	 * @return array Array with the whole current config
	 */
	public function toArray() {
		$this->_checkIsRead();

		$array = array();
		if (!is_array($this->_storedData)) {
			throw new Exception('data isnt an array: ' . var_dump($this->_storedData));
		}
		foreach ($this->_storedData as $key => $section) {
			$array[$key] = $section->toArray();
		}

		return $array;
	}

	/**
	 * Write the config file back to its source
	 *
	 * @return boolean True if writing was successful
	 */
	public function write() {
		return $this->_driver->write($this->toArray());
	}

	/**
	 * Magic getter for just fetch by property
	 *
	 * Get a section of the config.
	 * If the section you asked for doesnt
	 * exist, we just create a new one with an empty
	 * config specially for you ;)
	 *
	 * @return \Spaf\Library\Config\Section The section you asked for
	 */
	public function __get($name) {
		$this->_checkIsRead();

		if (!isset($this->_storedData[$name])) {
			$this->_storedData[$name] = new Section(array());
		}

		return $this->_storedData[$name];
	}

	/**
	 * Checks if the store is already rad from the underlaying
	 * driver, if not we just read it now
	 *
	 * @return boolean
	 */
	private function _checkIsRead() {
		if ($this->_storedData === null) {
			$this->read();
		}

		return true;
	}

}

?>