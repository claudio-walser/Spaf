<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Config/IniTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Config;

/**
 * \Spaf\_tests\Unit\Library\Config\IniTest
 *
 * The IniTest class tests any aspect of \Spaf\Library\Config\Driver\Ini.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Config
 * @namespace Spaf\_tests\Unit\Library\Config
 */
class IniTest extends Abstraction {

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
        parent::setUp();
    }

    public function testReadValue() {
        $masterServer = $this->_config->memcache->master_server;

        $this->assertEquals(
            'cache01',
            $masterServer
        );
    }

    public function testSetValue() {
        $this->_config->memcache->master_server = 'cache-test';

        var_dump($this->_config->memcache->test);
        $this->_config->memcache->test = 'just a test value';
        var_dump($this->_config->memcache->test);

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