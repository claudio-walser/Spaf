<?php
/**
 * $Id$
 * Benchmark timer class
 *
 * @created 	Wed Aug 18 18:42:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Cwa\Library\Benchmark
 * @namespace	\Cwa\Library\Benchmark
 */

namespace Cwa\Library\Benchmark;

/**
 * Benchmark timer class
 *
 * The timer class has only one method
 * to get the current microtime.
 *
 * @author		Claudio Walser
 */ 
class Timer {
	
	
	/**
	 * Get the current microtime
	 *
	 * This method returns the current timestamp in micro seconds.
	 *
	 * @return 	float	Microtime
	 */
	public static function getMicrotime() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}


}


?>