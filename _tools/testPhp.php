<?php

namespace Spaf\_tools;

class Test {

	public function __construct() {
		require_once('autoloader.php');
		$loader = new Autoloader();

		$filePath = '../_tests/Data/Config/config.php';
		$file = new \Spaf\Library\Directory\File($filePath);



		$config = new \Spaf\Library\Config\Manager();
		$config->registerDriver('php');
		$config->setSourceFile($file);
		//$config->types->null = 'null';

		/* * /
		// read for conversion
		$config->read();
		$filePath = '../_tests/Data/Config/config.json';
		$file = new \Spaf\Library\Directory\File($filePath);

		$config->registerDriver('json');
		$config->setSourceFile($file);
		$config->write();


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
$testIni = new \Spaf\_tools\Test();

?>