<?php
/**
 * Adapter for Cache
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache;

use CommonApi\Cache\CacheInterface;

/**
 * Adapter for Cache
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class Adapter implements CacheInterface
{
    /**
     * Cache Adapter Handler
     *
     * @var     object
     * @since   1.0
     */
    protected $adapterHandler;

    /**
     * Constructor
     *
     * @param   CacheInterface $cache
     *
     * @since   1.0
     */
    public function __construct(CacheInterface $cache)
    {
        $this->adapterHandler = $cache;
    }

    /**
     * Return cached or parameter value
     *
     * @param   string $key serialize name uniquely identifying content
     *
     * @return  bool|CacheItem cache for this key that has not been serialized
     * @since   1.0
     */
    public function get($key)
    {
        return $this->adapterHandler->get($key);
    }

    /**
     * Persist data in cache
     *
     * @param   string  $key
     * @param   mixed   $value
     * @param   integer $ttl (number of seconds)
     *
     * @return  bool
     * @since   1.0
     */
    public function set($key = null, $value, $ttl = 0)
    {
        return $this->adapterHandler->set($key, $value, $ttl);
    }

    /**
     * Remove cache for specified $key value
     *
     * @param   string $key serialize name uniquely identifying content
     *
     * @return  object CacheInterface
     * @since   1.0
     */
    public function remove($key = null)
    {
        return $this->adapterHandler->remove($key);
    }

    /**
     * Clear all cache
     *
     * @return  object CacheInterface
     * @since   1.0
     */
    public function clear()
    {
        return $this->adapterHandler->clear();
    }
}
