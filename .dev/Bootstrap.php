<?php
/**
 * Cache
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   MIT
 */
$base = substr(__DIR__, 0, strlen(__DIR__) - 5);

define('BASE_FOLDER', $base);

$classMap = array(
    'Molajo\\Cache\\Adapter'                              => BASE_FOLDER . '/Adapter.php',
    'Molajo\\Cache\\CacheItem'                            => BASE_FOLDER . '/CacheItem.php',
    'Molajo\\Cache\\Exception\\AbstractHandlerException'  => BASE_FOLDER . '/Exception/AbstractHandlerException.php',
    'Molajo\\Cache\\Exception\\AdapterException'          => BASE_FOLDER . '/Exception/AdapterException.php',
    'Molajo\\Cache\\Exception\\ApcHandlerException'       => BASE_FOLDER . '/Exception/ApcHandlerException.php',
    'Molajo\\Cache\\Exception\\CacheException'            => BASE_FOLDER . '/Exception/CacheException.php',
    'Molajo\\Cache\\Exception\\DatabaseHandlerException'  => BASE_FOLDER . '/Exception/DatabaseHandlerException.php',
    'Molajo\\Cache\\Exception\\DummyHandlerException'     => BASE_FOLDER . '/Exception/DummyHandlerException.php',
    'Molajo\\Cache\\Exception\\FileHandlerException'      => BASE_FOLDER . '/Exception/FileHandlerException.php',
    'Molajo\\Cache\\Exception\\MemcachedHandlerException' => BASE_FOLDER . '/Exception/MemcachedHandlerException.php',
    'Molajo\\Cache\\Exception\\MemoryHandlerException'    => BASE_FOLDER . '/Exception/MemoryHandlerException.php',
    'Molajo\\Cache\\Exception\\RedisHandlerException'     => BASE_FOLDER . '/Exception/RedisHandlerException.php',
    'Molajo\\Cache\\Exception\\WincacheHandlerException'  => BASE_FOLDER . '/Exception/WincacheHandlerException.php',
    'Molajo\\Cache\\Exception\\XCacheHandlerException'    => BASE_FOLDER . '/Exception/XCacheHandlerException.php',
    'Molajo\\Cache\\Api\\CacheAwareInterface'             => BASE_FOLDER . '/Api/CacheAwareInterface.php',
    'Molajo\\Cache\\Api\\CacheInterface'                  => BASE_FOLDER . '/Api/CacheInterface.php',
    'Molajo\\Cache\\Api\\CacheItemInterface'              => BASE_FOLDER . '/Api/CacheItemInterface.php',
    'Molajo\\Cache\\Api\\ConnectionInterface'             => BASE_FOLDER . '/Api/ConnectionInterface.php',
    'Molajo\\Cache\\Api\\ExceptionInterface'              => BASE_FOLDER . '/Api/ExceptionInterface.php',
    'Molajo\\Cache\\Handler\\AbstractHandler'             => BASE_FOLDER . '/Handler/AbstractHandler.php',
    'Molajo\\Cache\\Handler\\Apc'                         => BASE_FOLDER . '/Handler/Apc.php',
    'Molajo\\Cache\\Handler\\Database'                    => BASE_FOLDER . '/Handler/Database.php',
    'Molajo\\Cache\\Handler\\Dummy'                       => BASE_FOLDER . '/Handler/Dummy.php',
    'Molajo\\Cache\\Handler\\File'                        => BASE_FOLDER . '/Handler/File.php',
    'Molajo\\Cache\\Handler\\Memcached'                   => BASE_FOLDER . '/Handler/Memcached.php',
    'Molajo\\Cache\\Handler\\Memory'                      => BASE_FOLDER . '/Handler/Memory.php',
    'Molajo\\Cache\\Handler\\Redis'                       => BASE_FOLDER . '/Handler/Redis.php',
    'Molajo\\Cache\\Handler\\Wincache'                    => BASE_FOLDER . '/Handler/Wincache.php',
    'Molajo\\Cache\\Handler\\XCache'                      => BASE_FOLDER . '/Handler/XCache.php'
);

spl_autoload_register(
    function ($class) use ($classMap) {
        if (array_key_exists($class, $classMap)) {
            require_once $classMap[$class];
        }
    }
);
