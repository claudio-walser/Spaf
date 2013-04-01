<?php

namespace Spaf\tools;

class Test {

	public function __construct() {
		require_once('autoloader.php');
		$loader = new Autoloader();

		$filePath = '../tests/Data/Config/config.ini';
		$file = new \Spaf\Library\Directory\File($filePath);

		$config = new \Spaf\Library\Config\Manager();
		$config->registerDriver('ini');
		$config->setSourceFile($file);
		//$config->types->null = 'null';

		/* * /
		// read for conversion
		$config->read();
		$filePath = '../tests/Data/Config/config.xml';
		$file = new \Spaf\Library\Directory\File($filePath);

		$config->registerDriver('xml');
		$config->setSourceFile($file);
		$config->save();


		/* */

		echo '<pre>';
		$config->write();

		print_r($config->toArray());
		var_dump($config->toArray());
		//var_dump($newConfig->toArray());
		echo '</pre>';
		die();
	}

}

// run
$testIni = new Test();

?>