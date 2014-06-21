<?php
/**
 * $Id$
 * Database Generator - abstract parser class
 *
 * @created 	Mon Aug 23 19:13:57 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Cwa\Library\Database
 * @namespace	\Cwa\Library\Database
 */
namespace Cwa\Library\Orm\Generator\Parser;

/**
 * Cwa\Library\Orm\Generator\Parser\AbstractParser
 *
 * This class is the abstract parser class.
 * Any concrete parser has to extend this class
 * in order to work properly.
 *
 * @author 		Claudio Walser
 * @abstract
 */
abstract class AbstractParser {

	/**
	 * This array stores the Table objects after parsing
	 * @var			array
	 */
	protected $_tables = array();



	/**
	 * This array stores the Config object after parsing
	 * @var			Cwa\Library\Orm\Generator\Object\Config
	 */
	protected $_config = null;

	/**
	 * constructor
	 *
	 * Creates a simpleXml object of the given xmlFile parameter.
	 *
	 * This method expect a string with a valid path to a xml file as first parameter.
	 * It throw a UdaShemeParserException if the xml file wouldn't exist or isn't readable.
	 *
	 * @param		\Cwa\Library\Directory\File		A valid path to a sheme.xml
	 */
	public function __construct(\Cwa\Library\Directory\File $xmlFile) {
		$this->_loadFile($xmlFile);
	}

	abstract protected function _loadFile(\Cwa\Library\Directory\File $xmlFile);

	/**
	 * getObjects
	 *
	 * Empty abstract method
	 *
	 * This method has to be implemented in any child classes.
	 * It should return an array with all parsed Config Table objects.
	 *
	 * @abstract
	 * @return		array			Array with all UdaTable objects
	 * @access		public
	 */
	abstract public function getObjects();
}

?>