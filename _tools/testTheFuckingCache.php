<?php
$cache = \Spaf\Library\Cache\Manager::factory('memcache');

/**
 * Memcache
 */
$cache->connect('cache01');

$key = 'test2';
$value = 'super3';
$ttl = 20; // three seconds


if ($cache->exists($key) === false) {
	echo 'stored ';
	$cache->add($key, $value, $ttl);
}
var_dump($cache->get($key));
/*
sleep(6);

if ($cache->exists($key) === false) {
	echo 'stored ';
	$cache->add($key, $value, $ttl);
}

var_dump($cache->get($key));*/
echo '<br />';
die('fin');
?>