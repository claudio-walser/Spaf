<?php

/**
 * $Id$
 *
 * Spaf/_tests/Core/Controller/IndexTest.php
 * @created Wed Oct 3 19:56:13 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Core\Controller;

/**
 * \Spaf\_tests\Core\Controller\IndexTest
 *
 * The DispatcherTest class tests any aspect of \Spaf\Core\Controller\Index.
 *
 * @author Claudio Walser
 * @package \Spaf\_tests\Core\Controller
 * @namespace \Spaf\_tests\Core\Controller
 */
class NotFoundTest extends \PHPUnit_Framework_TestCase {

    private $_controller = null;
    private $_registry = null;
    /**
     * Setup both, normal and mock registry objects
     * 
     * @return void
     */
    protected function setUp() {
        $this->_registry = \Spaf\Core\Registry::getInstance();
        $request = new \Spaf\Core\Request\Http();
        $response = new \Spaf\Core\Response\Php();
        
        $this->_registry->set('request', $request, true);
        $this->_registry->set('response', $response, true);
        // get normal registry first
        $this->_controller = new \Spaf\Core\Controller\NotFound($this->_registry);
        
        unset($request);
        unset($response);
    }
    
    /**
     * Test the return value of the default view
     */
    public function testView() {
        $expectedData = array(
            'success' => true,
            'data' => 'notFound controllers listing method',
            'count' => 1
        );
        
        $data = $this->_controller->view();

        $this->assertEquals(
            $expectedData,
            $data
        ); 
    }
    
    /**
     * Release some memory maybe
     * (guess not since the instance is still somewhere, just not in this class as prop)
     * 
     * @return void
     */
    public function tearDown() {
        unset($this->_registry);
        unset($this->_controller);
    }
}

?>