<?php

/**
 * $Id$
 *
 * Spaf/Core/Response\AbstractResponse.php
 * @created Tue Jun 10 16:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Response;

/**
 * \Spaf\Core\Response\AbstractResponse
 *
 * Thats a base response class.
 * Any concrete response should extend this class.
 *
 * @author Claudio Walser
 * @package Spaf\Core\Response
 * @namespace Spaf\Core\Response
 * @abstract
 */
abstract class AbstractResponse {

	/**
	 * Either this class should utf8 encode outgoing values or not
	 *
	 * @var boolean True if outgoing values should be handled with utf8_encode
	 */
	protected $_encodeUtf8 = false;


	/**
	 * Abstract function write should be implemented by
	 * any child class. Output or forward the controllers
	 * return values. The return values of a controller is ALWAYS
	 * wrapped in a array like that:
	 * array(
	 * 		'success' => true || false
	 * 		'data' => Controller Return Values
	 * 		'count' => Can be set by controller to give the amount of all rows, only usefull in view/list methods and for paging
	 * )
	 *
	 * @param mixed Value to be returned
	 * @return mixed Value to be returned
	 */
	abstract function write($param);

}

?>