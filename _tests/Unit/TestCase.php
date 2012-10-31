<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Validator/Abstraction.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit;

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
abstract class TestCase extends \PHPUnit_Framework_TestCase {

    /**
     * Get path to the current directory
     *
     * @return void
     */
    protected function _getTestPath() {
        // build the full path
        $directory = __DIR__;

        $directories = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($directories);
        //array_pop($directories);
        //array_pop($directories);


        $path = implode(DIRECTORY_SEPARATOR, $directories);

        return $path;
    }

}

?>