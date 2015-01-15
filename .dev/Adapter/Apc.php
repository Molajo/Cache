<?php
/**
 * Apc Cache Adapter
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Adapter;

use Exception;
use CommonApi\Exception\RuntimeException;
use Molajo\Cache\CacheItem;
use CommonApi\Cache\CacheInterface;

/**
 * Apc Cache Adapter
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Apc extends AbstractAdapter implements CacheInterface
{
    /**
     * Constructor
     *
     * @param   array $options
     *
     * @since   1.0
     */
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'Apc';

        $this->connect($options);
    }

    /**
     * Connect to Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function connect($options = array())
    {
        parent::connect($options);

        if (extension_loaded('apc')
            && ini_get('apc.enabled')
        ) {
        } else {
            throw new RuntimeException('Cache APC: APC is not enabled');
        }

        return $this;
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  bool|CacheItem
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($key)
    {
        if ($this->cache_enabled == 0) {
            return false;
        }

        try {
            $exists = apc_exists($key);
            $value  = apc_fetch($key);
            return new CacheItem($key, $value, $exists);
        } catch (Exception $e) {
            throw new RuntimeException
            (
                'Cache: Get Failed for Apc ' . $e->getMessage()
            );
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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function set($key, $value = null, $ttl = 0)
    {
        if ($this->cache_enabled == 0) {
            return false;
        }

        if ($key === null) {
            $key = serialize($value);
        }

        if ((int)$ttl == 0) {
            $ttl = (int)$this->cache_time;
        }

        $results = apc_add($key, $value, (int)$ttl);

        if ($results === false) {
            throw new RuntimeException
            (
                'Cache APC Adapter: Set failed.'
            );
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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function remove($key = null)
    {
        $results = apc_delete($key);

        if ($results === false) {
            throw new RuntimeException
            (
                'Cache APC Adapter: Remove cache failed.'
            );
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
