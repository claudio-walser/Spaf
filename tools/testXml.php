<?php

namespace Spaf\tools;

class Test {

	public function __construct() {
		/*echo serialize(array('float' => 7.1));
		var_dump((double) 7.1);
		die();*/
		require_once('autoloader.php');
		$loader = new Autoloader();

		$filePath = '../tests/Data/Config/config.xml';
		$file = new \Spaf\Library\Directory\File($filePath);



		$config = new \Spaf\Library\Config\Manager();
		$config->registerDriver('xml');
		$config->setSourceFile($file);
		//
		/* * /
		$config->types->boolean = true;
		$config->types->null = null;
		$config->types->string = "some content with = equals and \"double qoutes\"";
		$config->types->integer = 5;
		$config->types->signed = -1;
		$config->types->float = 7.1;
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