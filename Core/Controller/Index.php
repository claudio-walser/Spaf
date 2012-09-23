<?php

/**
 * $Id$
 *
 * Spaf/Core/Controller/Index.php
 * @created Tue Jun 10 19:25:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Controller;

use \Spaf\Core\Controller;

/**
 * \Spaf\Core\Controller\Index
 *
 * Default index controller.
 *
 * @author Claudio Walser
 * @package \Spaf\Core\Controller
 * @namespace \Spaf\Core\Controller
 */
class Index extends Controller {
	
	/**
	 * Default controllers view method
	 * 
	 * @return string Just a default string
	 */
	public function view() {
		return $this->_response->write('default controllers listing method');
	}
	
}

?>