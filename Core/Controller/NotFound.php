<?php

/**
 * $Id$
 *
 * Spaf/Core/Controller/NotFound.php
 * @created Tue Jun 10 19:25:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Controller;

use \Spaf\Core\Controller;

/**
 * \Spaf\Core\Controller\NotFound
 *
 * Default NotFound controller.
 *
 * @author Claudio Walser
 * @package \Spaf\Core\Controller
 * @namespace \Spaf\Core\Controller
 */
class NotFound extends Controller {
	
	/**
	 * NotFound controllers view method
	 * 
	 * @return string Just a default string
	 */
	public function view() {
		throw new Exception(get_class($this) . ': You try to call the inexistent controller "' . $this->_registry->getParam('controller', 'index') . '"');
	}
	
}

?>