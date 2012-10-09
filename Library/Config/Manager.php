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
	private $_default = 'Driver\\Ini';

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
     * Register one of the driver type.
	 * Currently supported is ini, xml, json, php (simple array) and a simple serialized format
     *
     * @param string Driver type
     * @return boolean True
     */
	public function registerDriver($driver) {
		switch (strtoupper($driver)) {
			case 'ini':
				$this->_driver = new Driver\Ini();
				break;

			case 'xml':
				$this->_driver = new Driver\Xml();
				break;

			case 'php':
				$this->_driver = new Driver\Php();
				break;

			case 'json':
				$this->_driver = new Driver\Json();
				break;

			case 'serialized':
				$this->_driver = new Driver\Serialized();
				break;

			default:
				$this->_driver = new $this->_default();
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
		$this->_storedData = $this->_driver->read($file);

		return true;
	}

    /**
     * Get the configs of one section as array
     *
     * @param string Section to read
     * @return mixed NULL or the given section as array
     */
	public function getSection($section) {
		if (is_array($this->_storedData['data']) && array_key_exists($section, $this->_storedData['data'])) {
			return $this->_storedData['data'][$section];
		}

		return null;
	}

    /**
     * Defines a full section as constants.
     *
     * @param string Section to define as constants
     * @return boolean True
     */
	public function getSectionAsConstants($section) {
		$configs = $this->getSection($section);
		if ($configs !== null) {
			foreach ($configs as $key => $conf) {
				if (!defined($key)) {
					define($key, $conf);
				}
			}
		}

		return true;
	}

    /**
     * Returns the config variables of all sections
     *
     * @return array Multinested array with all sections
     */
	public function getAll() {
		return $this->_storedData['data'];
	}

    /**
 	 * Create or overwrite a section
     *
     * @param array Associative array with the values
     * @param string Name of the section
     * @return boolean True
     */
	public function setSection(array $assoc_array, $section) {
		$this->_storedData['data'][$section] = $assoc_array;

		return true;
	}

    /**
     * Remove a section
     *
     * @param string Name of the section to remove
     * @return boolean True
     */
	public function deleteSection($section_name) {
		if (isset($this->_storedData['data'][$section_name])) {
			unset($this->_storedData['data'][$section_name]);
		}

		return true;
	}

    /**
     * Remove all sections
     *
     * @return boolean True
     */
	public function deleteAll() {
		if (isset($this->_storedData)) {
			$this->_storedData = null;
		}

		return true;
	}

	/**
	 * Set new config sections.
	 * The old one's will be removed, so its a
	 * complete rewrite.
	 *
     * @param array Multinested array to set new data
     * @return boolean True
	 */
	public function setAll(Array $assoc_array) {
		$this->_storedData = $assoc_array;

		return true;
	}

	/**
	 * Write the config file back to its source
	 *
     * @return boolean True if writing was successful
	 */
	public function save() {
		return $this->_driver->save($this->_storedData);
	}

	/**
	 * List all available sections,
	 *
     * @return array An array with all available sections in this config
	 */
	public function getSections() {
		if ($this->_storedData['data'] !== null) {
			$array = array();
			foreach ($this->_storedData as $key => $data) {
				$array[] = $key;
			}
			if (empty($array)) {
				$array = null;
			}
		} else {
			$array = null;
		}

		return $array;
	}

}

?>