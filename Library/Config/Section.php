<?php

/**
 * $Id$
 *
 * Spaf/Library/Config/Section.php
 * @created Sat Sep 09 08:17:23 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config;

/**
 * \Spaf\Library\Config\Section
 *
 * Represents just one section of a config
 *
 * @author Claudio Walser
 * @package Spaf\Library\Config
 * @namespace Spaf\Library\Config
 */
class Section {

    /**
     * Current config array.
     *
     * @var array
     */
    private $_storedData = array();

	/**
	 * Constructor just stores the given
	 * data array into class prop.
	 */
    public function __construct($data) {
        $this->_storedData = $data;

		return true;
    }

	/**
	 * Return the whole section data as array
	 *
	 * @return array Array with the whole section data
	 */
	public function toArray() {
		return $this->_storedData;
	}

	/**
	 * Magic getter for just fetch by property
	 *
	 * Get a property of this section
	 *
	 * @TODO Think about conversion of some types 'true' to boolean and stuff like that, think i had that in earlier versions of my framework
	 * @return string The property you asked for
	 */
    public function __get($name) {
        if (isset($this->_storedData[$name])) {
            return $this->_storedData[$name];
        }
        return null;
    }

	/**
	 * Magic set for just set by property
	 *
	 * Set/overwrite a property of this section
	 *
	 * @TODO Think about conversion of some types boolean to 'true' and stuff like that, think i had that in earlier versions of my framework
	 * @param string The property name you want to set/overwrite
	 * @param string The property value you want to give
	 * @return boolean
	 */
    public function __set($name, $value) {
        $this->_storedData[$name] = $value;

        return true;
    }

}

?>