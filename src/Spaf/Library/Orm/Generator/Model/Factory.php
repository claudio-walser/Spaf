<?php

namespace Spaf\Library\Orm\Generator\Model;

/**
 * UdaModelGenerator.php :: Factory for model generator
 *
 * This class is just a factory to instantiate the right classes
 * for the given language. Currently, just php5 is supported.
 *
 * @abstract
 * @category	ModelGenerator
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */
abstract class Factory {

	/**
	 * factory
	 *
	 * Creates an instance of the right Generator classes.
	 *
	 * Factory method to create the right generator classes
	 * addicted to php version.
	 *
	 * @param		array		model		Array wich includes a set of UdaTable objects
	 * @param		string		targetPath	Path to save the generated model files
	 * @param		string		phpVersion	Optional: Your needed php version, currently, just php5 is supportet. So the default value is 5
	 * @return		UdaModelGenerator		Right object of a extended UdaModelGenerator class
	 * @access		public
	 */
	public static function create($model, $targetPath, $phpVersion = 5) {
		if ($phpVersion == 5) {
			return new Php5($model, $targetPath);
		} else if ($phpVersion == 6) {
			return new Php6($model, $targetPath);
		}

		throw new Exception('PHP Version ' . $phpVersion . ' not available');
		return false;
	}
}

?>