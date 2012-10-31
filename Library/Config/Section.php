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
    
    public function __construct($data) {
        $this->_storedData = $data;
        
        //print_r($data);
    }
    
    public function __get($name) {
        if (isset($this->_storedData[$name])) {
            return $this->_storedData[$name];
        }
        return null;
    }

    public function __set($name, $value) {
        $this->_storedData[$name] = $value;
        
        return true;
    }
    
}

?>