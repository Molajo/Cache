<?php
/**
 * Cache
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    MIT
 */
$base = substr(__DIR__, 0, strlen(__DIR__) - 5);

define('BASE_FOLDER', $base);

$classMap = array(
    'Molajo\\Cache\\Adapter'                      => BASE_FOLDER . '/Adapter.php',
    'Molajo\\Cache\\CacheItem'                    => BASE_FOLDER . '/CacheItem.php',
    'Exception\\Cache\\AbstractHandlerException'  => BASE_FOLDER . '/Exception/AbstractHandlerException.php',
    'Exception\\Cache\\AdapterException'          => BASE_FOLDER . '/Exception/AdapterException.php',
    'Exception\\Cache\\ApcHandlerException'       => BASE_FOLDER . '/Exception/ApcHandlerException.php',
    'Exception\\Cache\\CacheException'            => BASE_FOLDER . '/Exception/CacheException.php',
    'Exception\\Cache\\DatabaseHandlerException'  => BASE_FOLDER . '/Exception/DatabaseHandlerException.php',
    'Exception\\Cache\\DummyHandlerException'     => BASE_FOLDER . '/Exception/DummyHandlerException.php',
    'Exception\\Cache\\FileHandlerException'      => BASE_FOLDER . '/Exception/FileHandlerException.php',
    'Exception\\Cache\\MemcachedHandlerException' => BASE_FOLDER . '/Exception/MemcachedHandlerException.php',
    'Exception\\Cache\\MemoryHandlerException'    => BASE_FOLDER . '/Exception/MemoryHandlerException.php',
    'Exception\\Cache\\RedisHandlerException'     => BASE_FOLDER . '/Exception/RedisHandlerException.php',
    'Exception\\Cache\\WincacheHandlerException'  => BASE_FOLDER . '/Exception/WincacheHandlerException.php',
    'Exception\\Cache\\XCacheHandlerException'    => BASE_FOLDER . '/Exception/XCacheHandlerException.php',
    'Molajo\\Cache\\CommonApi\\CacheInterface'          => BASE_FOLDER . '/Api/CacheInterface.php',
    'Molajo\\Cache\\CommonApi\\CacheItemInterface'      => BASE_FOLDER . '/Api/CacheItemInterface.php',
    'Molajo\\Cache\\CommonApi\\ConnectionInterface'     => BASE_FOLDER . '/Api/ConnectionInterface.php',
    'Molajo\\Cache\\CommonApi\\ExceptionInterface'      => BASE_FOLDER . '/Api/ExceptionInterface.php',
    'Molajo\\Cache\\Handler\\AbstractHandler'     => BASE_FOLDER . '/Handler/AbstractHandler.php',
    'Molajo\\Cache\\Handler\\Apc'                 => BASE_FOLDER . '/Handler/Apc.php',
    'Molajo\\Cache\\Handler\\Database'            => BASE_FOLDER . '/Handler/Database.php',
    'Molajo\\Cache\\Handler\\Dummy'               => BASE_FOLDER . '/Handler/Dummy.php',
    'Molajo\\Cache\\Handler\\File'                => BASE_FOLDER . '/Handler/File.php',
    'Molajo\\Cache\\Handler\\Memcached'           => BASE_FOLDER . '/Handler/Memcached.php',
    'Molajo\\Cache\\Handler\\Memory'              => BASE_FOLDER . '/Handler/Memory.php',
    'Molajo\\Cache\\Handler\\Redis'               => BASE_FOLDER . '/Handler/Redis.php',
    'Molajo\\Cache\\Handler\\Wincache'            => BASE_FOLDER . '/Handler/Wincache.php',
    'Molajo\\Cache\\Handler\\XCache'              => BASE_FOLDER . '/Handler/XCache.php'
);

spl_autoload_register(
    function ($class) use ($classMap) {
        if (array_key_exists($class, $classMap)) {
            require_once $classMap[$class];
        }
    }
);
