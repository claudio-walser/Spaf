<?php

/**
 * $ID$
 *
 * Spaf/Library/Cache/Apc.php
 * @author Claudio Walser
 * @created Wed Oct 10 18:57:56 +0200 2012
 * @reviewer TODO
 */
namespace Spaf\Library\Cache;

/**
 * \Spaf\Library\Cache\Apc
 *
 * Concrete APC Cache Class.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Cache
 * @namespace Spaf\Library\Cache
 */
class Apc extends Abstraction {

	/**
	 * Constructs the APC cache.
	 * Constructor is throwing an Exception if no APC is installed
	 * locally.
	 *
	 * @return void
	 */
	public function __construct() {
		if (!function_exists('apc_add')) {
			throw new Exception('APC is not installed on this server.');
		}
	}

}