<?php
/**
 * Memory Cache
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Adapter;

use Molajo\Cache\CacheItem;
use CommonApi\Cache\CacheInterface;

/**
 * Memory Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Memory extends AbstractAdapter implements CacheInterface
{
    /**
     * Cache Container
     *
     * @var    array
     * @since  1.0
     */
    protected $cache_container = array();

    /**
     * Constructor
     *
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'Memory';

        $this->connect($options);
    }

    /**
     * Connect to Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     */
    public function connect($options = array())
    {
        parent::connect($options);

        $this->cache_container = array();

        return $this;
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  CacheItem
     * @since   1.0
     */
    public function get($key)
    {
        return parent::get($key);
    }

    /**
     * Create Cache Item
     *
     * @param   string $key
     *
     * @return  CacheItem
     * @since   1.0
     */
    protected function createCacheItem($key)
    {
        $value  = null;
        $exists = false;

        if (isset($this->cache_container[$key])) {
            $entry  = $this->cache_container[$key];
            $exists = true;
            $value  = $entry->value;
        }

        return array($value, $exists);
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
     */
    public function set($key, $value = null, $ttl = 0)
    {
        if ($this->cache_enabled == 0) {
            return false;
        }

        if ((int)$ttl == 0) {
            $ttl = (int)$this->cache_time;
        }

        $this->cacheItem($key, $value, $ttl);

        return $this;
    }

    /**
     * Cache Item
     *
     * @param   string  $key
     * @param   mixed   $value
     * @param   integer $ttl
     *
     * @return  object
     * @since   1.0
     */
    protected function cacheItem($key, $value, $ttl)
    {
        if ($key === null) {
            $key = serialize($value);
        }

        $entry          = new \stdClass();
        $entry->value   = $value;
        $entry->expires = $ttl;

        $this->cache_container[$key] = $entry;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param   string $key
     *
     * @return  Memory
     * @since   1.0
     */
    public function remove($key = null)
    {
        if (isset($this->cache_container[$key])) {
            unset($this->cache_container[$key]);
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
        return $this->cache_container = array();
    }
}
