<?php

/**
 * $ID$
 *
 * Spaf/_tools/info.php
 * @author Claudio Walser
 * @created Wed Oct 10 18:57:56 +0200 2012
 * @reviewer TODO
 */
namespace Spaf\_tools;

/**
 * \Spaf\_tests\Info
 *
 * phpinfo.
 *
 * @author Claudio Walser
 * @package Spaf\_tools
 * @namespace Spaf\_tools
 */
final class Info {

	/**
	 * Run the info tool
	 *
	 * @return void
	 */
	public function __construct() {
		phpinfo();
	}
}

// run
$info = new Info();

?>