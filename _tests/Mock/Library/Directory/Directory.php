<?php

/**
 * $ID$
 *
 * Spaf/_tests/Mock/Library/Directory/Directory.php
 * @author Claudio Walser
 * @created Fri Sep 28 10:39:08 +0200 2012
 * @reviewer TODO
 */
namespace Spaf\_tests\Mock\Library\Directory;


class Directory extends \Spaf\Library\Directory\Directory {

	/**
	 * Default classname to instantiate directories
	 * 
	 * @var string
	 */
	protected $_defaultDirectoryClass = '\Spaf\_tests\Mock\Library\Directory\Directory';

	/**
	 * Default classname to instantiate files
	 * 
	 * @var string
	 */
	protected $_defaultFileClass = '\Spaf\_tests\Mock\Library\Directory\File';
	
	
}

?>