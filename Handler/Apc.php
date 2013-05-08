<?php
/**
 * Apc Cache Handler
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Exception;
use Molajo\Cache\CacheItem;
use Molajo\Cache\Api\CacheInterface;
use Molajo\Cache\Exception\ApcHandlerException;

/**
 * Apc Cache Handler
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Apc extends AbstractHandler implements CacheInterface
{
    /**
     * Constructor
     *
     * @param   string $cache_handler
     *
     * @since   1.0
     */
    public function __construct($cache_handler = 'Apc')
    {
        parent::__construct($cache_handler);
    }

    /**
     * Connect to Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  ApcHandlerException
     */
    public function connect($options = array())
    {
        return parent::connect($options);
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  bool|CacheItem
     * @since   1.0
     * @throws  ApcHandlerException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {
            $exists = apc_exists($key);
            $value = apc_fetch($key);
            return new CacheItem($key, $value, $exists);

        } catch (Exception $e) {
            throw new ApcHandlerException
            ('Cache: Get Failed for Apc ' . $e->getMessage());
        }
    }

    /**
     * Create a cache entry
     *
     * @param   null    $key
     * @param   null    $value
     * @param   integer $ttl (number of seconds)
     *
     * @return  $this
     * @since   1.0
     * @throws  ApcHandlerException
     */
    public function set($key = null, $value = null, $ttl = 0)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        if ($key === null) {
            $key = md5($value);
        }

        if ((int)$ttl == 0) {
            $ttl = (int)$this->cache_time;
        }

        $results = apc_add($key, $value, (int)$ttl);

        if ($results === false) {
            throw new ApcHandlerException
            ('Cache APC Handler: Set failed.');
        }

        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param   string $key
     *
     * @return  object
     * @since   1.0
     * @throws  ApcHandlerException
     */
    public function remove($key = null)
    {
        $results = apc_delete($key);

        if ($results === false) {
            throw new ApcHandlerException
            ('Cache APC Handler: Remove cache failed.');
        }

        return $this;
    }

    /**
     * Clear all cache
     *
     * @return  $this
     * @since   1.0
     */
    public function clear()
    {
        return apc_clear_cache('user');
    }
}
