<?php
/**
 * Cache
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */
define('MOLAJO', 'This is a Molajo Distribution');

if (substr($_SERVER['DOCUMENT_ROOT'], - 1) == '/') {
    define('ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT']);
} else {
    define('ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/');
}

$base = substr(__DIR__, 0, strlen(__DIR__) - 5);
define('BASE_FOLDER', $base);

//include BASE_FOLDER . '/Tests/Testcase1/Data.php';

$classMap = array(
    'Molajo\\Cache\\Exception\\CacheException'     => BASE_FOLDER . '/Exception/CacheException.php',
    'Molajo\\Cache\\Exception\\ExceptionInterface' => BASE_FOLDER . '/Exception/ExceptionInterface.php',
    'Molajo\\Cache\\Adapter\\CacheInterface'       => BASE_FOLDER . '/Adapter/CacheInterface.php',
    'Molajo\\Cache\\Type\\FileCache'               => BASE_FOLDER . '/Type/FileCache.php',
    'Molajo\\Cache\\Adapter'                       => BASE_FOLDER . '/Adapter.php',
);

spl_autoload_register(
    function ($class) use ($classMap) {
        if (array_key_exists($class, $classMap)) {
            require_once $classMap[$class];
        }
    }
);

/*
include BASE_FOLDER . '/' . 'ClassLoader.php';
$loader = new ClassLoader();
$loader->add('Molajo', BASE_FOLDER . '/src/');
$loader->add('Testcase1', BASE_FOLDER . '/Tests/');
$loader->register();
*/
