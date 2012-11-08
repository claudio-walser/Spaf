<?php

namespace Spaf\_tools;

class TestIni {

    public function __construct() {
        require_once('autoloader.php');
        $loader = new Autoloader();
        
        $filePath = '../_tests/Data/Config/php.ini';
        $file = new \Spaf\Library\Directory\File($filePath);
        
        $config = new \Spaf\Library\Config\Manager();
        $config->registerDriver('ini');
        $config->setSourceFile($file);
        
        $config->specials->boolean = true;
        $config->specials->nothing = null;
        //$config->save();
        
        $newConfig = new \Spaf\Library\Config\Manager();
        $newConfig->registerDriver('ini');
        $newConfig->setSourceFile($file);
        
        echo '<pre>';
        var_dump($config->toArray());
        var_dump($newConfig->toArray());
        echo '</pre>';
        die();
    }

}

// run
$testIni = new \Spaf\_tools\TestIni();

?>