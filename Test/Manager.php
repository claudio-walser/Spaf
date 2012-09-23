<?php

namespace Spaf\Test;

class Manager {
	
	private $_runner = null;
	private $_suite = null;
	
	public function __construct() {
		$this->_runner	= new PHPUnit_TextUI_TestRunner;
		$this->_suite = new PHPUnit_Framework_TestSuite('Spaf - Framework Testing Suite');
	}
	
}

?>