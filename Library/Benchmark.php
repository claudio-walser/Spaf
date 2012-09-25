<?php
/**
 * $Id$
 * Benchmark class
 *
 * @created 	Wed Aug 18 18:42:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Cwa\Library\Benchmark
 * @namespace	\Cwa\Library
 */

namespace Cwa\Library;

/**
 * Benchmark class
 *
 * This class is usefull for getting the execution time
 * and also the currently used memory usage.
 *
 * @singleton
 * @author		Claudio Walser
 */ 
class Benchmark {
	
	
    /**
     * Stores the current instance.
	 * Needed for the singleton pattern.
     *
     * @var		array
     */
	private static $_instance = array();

    /**
     * Stores all the markers.
     *
     * @var		array
     */
	private $_markers = array();
		
    /**
     * Constructor
     * 
	 * Constructor has no functionality. Its just implemented as private
	 * for the singleton pattern.
     *
	 * @access	private
     */
	private function __construct() {}
	
	
    /**
     * Get single instance of this class
     * Creates an instance of this class.
	 * You can pass an instance name to have more than one instance.
     *
	 * @access	public
	 * @param 	string			Key of the instance
	 * @return	\Cwa\Library\Benchmark\Singleton
     */
	public static function getInstance($name = 'bench') {
		if (!isset(self::$_instance[$name])) {
			self::$_instance[$name] = new self();
		}
		return self::$_instance[$name];
	}
	
    /**
     * Set a marker.
	 * Set a marker with a given string.
	 * It stores the current microtime and 
	 * also the currently memory usage
     *
	 * @param	string		The marker key
	 * @return	bool
     */
	public function setMarker($marker) {
		$this->_markers[$marker]['time'] = Benchmark\Timer::getMicrotime();
		$this->_markers[$marker]['memory'] = memory_get_usage();		
		return true;
	}
	
	
    /**
     * Calculate the results
	 * You will see the differents of all steps.
	 * Also at the end, the total execution time
	 " and memory usage will be calculated.
     *
	 * @access	public
	 * @return	bool
     */
	public function getInfo($block = null) {
		$return = '';
		
		if ($block === null) {
			$i = 1;
			$max = count($this->_markers);
			foreach ($this->_markers as $key => $marker) {
				$return .= '<b>' . $key . "</b>\n";
				if ($i === 1) {
					$start = $marker['time'];
					$startMemory = $marker['memory'];
					$return .= ' => 0.0 Sekunden<br />' . "\n";
					$return .= ' => ' . $this->_formateBytes($marker['memory']) . ' Bytes Speicherverbrauch<br />' . "\n";
				} else {
					$seconds = $marker['time'] - $last_marker;
					$return .= ' => ' . $seconds . ' Sekunden<br />' . "\n";
					$return .= ' => ' . $this->_formateBytes($marker['memory']) . ' Bytes Speicherverbrauch<br />' . "\n";
					$end = $marker['time'];
					$endMemory = $marker['memory'];
				}
				$last_marker = $marker['time'];
				$i++;
			}
			$return .= 'Totale Ausf�hrzeit: ' . ($end - $start) . ' Sekunden<br />' . "\n";
			$return .= 'Totaler Memory Verbrauch: ' . $this->_formateBytes($endMemory - $startMemory) . ' Bytes<br />' . "\n";
		
		
		
		} else if (isset($this->_markers[$block])) {
			$_marker = $this->_markers[$block];
			reset($this->_markers);
			while($marker = current($this->_markers)) {
				if($marker === $_marker) {
					break;
				}
				next($this->_markers);
			}
			
			$last_marker = prev($this->_markers);
			$seconds = $marker['time'] - $last_marker['time'];
			$return .= ' => ' . $seconds . ' Sekunden<br />' . "\n";
		}
		return $return;
	}
	
	private function _formateBytes($bytes) {
		if ($bytes < 1024)
            return $bytes . " Bytes";
        elseif ($bytes < 1048576)
            return round($bytes/1024, 2) . " Kilobytes";
        else
            return round($bytes/1048576, 2) . " Megabytes"; 		
	}
	
}


?>