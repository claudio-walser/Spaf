<?php

/**
 * $Id$
 *
 * Spaf/_tools/beautify.php
 * @created Tue Sep 25 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tools;

/**
 * \Spaf\_tools\test
 *
 * Tool for beautify the code to Spaf rules
 *
 * @author Claudio Walser
 * @package Spaf\_tools
 * @namespace Spaf\_tools
 */
final class Beautify {

	/**
	 * Run the beautify tool
	 *
	 * @return void
	 */
	public function __construct() {
		// hack server argv for windows console
		if (!isset($_SERVER['argv']) && !empty($_GET)) {
			$_SERVER['argv'] = array('scriptname');

			foreach ($_GET as $key => $value) {
				$_SERVER['argv'][] = $key;
			}
		}

		// error reporting on
		error_reporting(E_ALL);

		// chdir to root _tools direcotry in any case
		chdir(__DIR__);

		// requiere test-autoloader environment
		require_once('autoloader.php');
		$loader = new \Spaf\_tools\Autoloader();

		// instantiate manager
		$beautifier = new \Spaf\Library\Code\Php\Beautifier();
		$directory = new \Spaf\Library\Directory\Directory('../');
		$files = $directory->getChildren('*.php,*.xml', 'file', true);

		$beautifier->setFiles($files);
		$beautifier->beautify();

		foreach ($files as $file) {
			// path of the original file
			$orig = $file->getPath() . $file->getName();
			// new path
			$new = '../../SpafDuplicate/' . substr($orig, 3, strlen($orig));
			// write the file to the new path
			try {
				$file->write($orig);
			} catch (\Spaf\Library\Directory\Exception $e) {
				// thrown if try to save an empty file, we have some int our _tests/Data folder
			}
		}
	}
}

// run
$beautify = new Beautify();

?>