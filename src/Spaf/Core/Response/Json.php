<?php

/**
 * $Id$
 *
 * Spaf/Core/Response/Json.php
 * @created Tue Jun 10 16:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Response;

/**
 * \Spaf\Core\Response\Json
 *
 * The class for handling json responses.
 * Usefull to responding to ajax calls or any other
 * api client.
 *
 * @author Claudio Walser
 * @package Spaf\Core\Response
 * @namespace Spaf\Core\Response
 */
class Json extends Php {

	/**
	 * Constructor is sending the json header.
	 */
	public function __construct() {
		header("Content-Type: application/json");
	}

	/**
	 * Write the json output per echo.
	 * This is ALWAYS outputting an array like the following
	 * array(
	 * 		success => true || false
	 * 		data => the gifen $param
	 * 		count => amount of $param or your given value if not null
	 * )
	 * If you dont want all these informations, just pass $pure=true as fourth parameter.
	 *
	 * @see \Spaf\Core\Response\Php::write()
	 *
	 * @param mixed Your return value
	 * @param int Number of all rows if you use paging
	 * @param boolean Give a fixed success value if you want to return NULL explicit for example
	 * @param boolean Pass true if you want to return the pure data without success and count values
	 * @return true
	 */
	public function write($param, $count = null, $success = null, $pure = false) {
		return json_encode(parent::write($param, $count, $success, $pure));
	}

}

?>