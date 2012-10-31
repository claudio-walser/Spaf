<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Validator/Abstraction.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Config;

/**
 * \Spaf\_tests\Unit\Library\Config\Abstraction
 *
 * The Abstraction class is a base class for any further config test.
 * But its not a test by itself
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Config
 * @namespace Spaf\_tests\Unit\Library\Config
 */
abstract class Abstraction extends \Spaf\_tests\Unit\TestCase {

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
     * Setup
     *
     * @return void
     */
    protected function setUp() {
        $path = $this->_getTestPath() . '/Data/Config/';
        // instantiate file object
        $file = new \Spaf\Library\Directory\File($path . $this->_filename);

        // instantiate config manager object and pass file and driver type
        $this->_config = new \Spaf\Library\Config\Manager();
        $this->_config->registerDriver($this->_driver);
        $this->_config->setSourceFile($file);

        unset($file);
    }

    /**
     * Release some memory maybe
     * (guess not since the instance is still somewhere, just not in this class as prop)
     *
     * @return void
     */
    protected function tearDown() {
        unset($this->_config);
    }

}

?>