<?php
/**
 * $Id$
 * Benchmark iterator class
 *
 * @created 	Wed Aug 18 18:42:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Cwa\Library\Benchmark
 * @namespace	\Cwa\Library\Benchmark
 */

namespace Cwa\Library\Benchmark;

/**
 * BenchmarkIterator.php :: Laufzeit-Analyse von Funktionen und Methoden
 *
 * The benchmark iterator is usefull to call 
 * a function or a method more times in a loop.
 * This getting a more accurat result.
 *
 * @author		Claudio Walser
 */ 
class Iterator {
	
	
	
	
    /**
     * Gets the execution time of a prcedural function
     * 
	 * Loops through a function in order of the given parameters.
	 * To this method, you can pass as many parameters as you like.
	 * The first two params will be affected by the method itself.
	 * All other will be passed to the iterating function as parameters
	 * parameters. 
     *
	 * @throws	\Cwa\Library\Benchmark\Exception	Wrong count Parameter Exception
	 * @access	public
	 * @param 	int					Number of iterations
	 * @param 	string				Name of the function
	 * @param 	mixed				More parameters are passed to the function
	 * @return	string
     */
	public function iterateFunction($iterations, $func_name) {
		// Outputbuffer for preventing output
		ob_start();
		
		$args = func_get_args();
		if (empty($args) || count($args) < 2) {
			throw new Exception('Check params for BenchmarkIterator::iterateFunction(int <b>$runs</b>, string <b>$func_name</b>, [mixed $func_param, [mixed $func_param]])');
		}
		$iterations = intval(array_shift($args));
		$func_name = array_shift($args);
		$params = $args;
		$start = Timer::getMicrotime();
		for ($i = 1; $i <= $iterations; $i++) {
			call_user_func_array($func_name, $params);
		}
		$end = Timer::getMicrotime();
		$runtime = $end - $start;
		
		// clear output buffer
		ob_end_clean();
		
		$return  = 'Benchmark Statistik für die Funktion <b>' . $func_name . '()</b>' . "\n";
		$return .= 'Statistik bei <b>' . $iterations . '</b> Durchläufen' . "\n";
		$return .= 'Durchschnittliche Ausführzeit: <b>' . $runtime / $iterations . '</b> Sekunden' . "\n";
		$return .= 'Totale Ausführzeit: <b>' . $runtime . '</b> Sekunden' . "\n";
		return $return;
	}
	
	
    /**
     * Gets the execution time of a oo method
     * 
	 * Loops through a method in order of the given parameters.
	 * To this method, you can pass as many parameters as you like.
	 * The first four params will be affected by the method itself.
	 * All other will be passed to the iterating method as parameters
	 * parameters. 
     *
	 * @throws	\Cwa\Library\Benchmark\Exception	Wrong count Parameter Exception
	 * @access	public
	 * @param 	int					Number of iterations
	 * @param 	mixed				Object or name of the class in case of a static method
	 * @param 	string				Name of the method
	 * @param 	mixed				More parameters are passed to the function
	 * @return	string
     */
	public function iterateMethod($iterations, $object, $func_name, $static) {
		// Start output buffer for preventing outputs
		ob_start();
		
		$args = func_get_args();
		if (empty($args) || count($args) < 4) {
			throw new Exception('Obligate params for Benchmark::iterateMethod(int <b>$runs</b>, string <b>$method_name</b>, [mixed $func_param, [mixed $func_param]])');
		}
		
		$iterations = intval(array_shift($args));
		$object = array_shift($args);
		$func_name = array_shift($args);
		$static = array_shift($args);
		
		if (!is_object($object) && $static === false) {
			$object = new $object();
		}
		
		
		$start = Timer::getMicrotime();
		for ($i = 1; $i <= $iterations; $i++) {
			call_user_method_array($func_name, $object, $args);
		}
		$end = Timer::getMicrotime();
		$runtime = $end - $start;
		
		// clear the output buffer
		ob_end_clean();
		
		return 'Totale Ausführzeit: <b>' . ($runtime) . '</b> Sekunden für <b>' . $iterations . '</b> Durchläufe der Funktion <b>' . $func_name . '()</b><br />' . "\n";
	}
	
	
}


?>