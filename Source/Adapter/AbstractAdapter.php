<?php
/**
 * Abstract Adapter for Cache
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Adapter;

use Molajo\Cache\CacheItem;
use CommonApi\Cache\CacheInterface;

/**
 * Abstract Adapter Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class AbstractAdapter implements CacheInterface
{
    /**
     * Cache Adapter
     *
     * @var    string
     * @since  1.0
     */
    protected $cache_handler;

    /**
     * Cache
     *
     * @var    bool
     * @since  1.0
     */
    protected $cache_enabled = false;

    /**
     * Cache Time in seconds
     *
     * @var    Integer
     * @since  1.0
     */
    protected $cache_time = 86400;

    /**
     * Constructor
     *
     * @param   string $cache_handler
     * @param   array  $options
     *
     * @since   1.0
     */
    public function __construct(array $options = array())
    {
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
        if (isset($options['cache_enabled'])) {
            $this->cache_enabled = (boolean)$options['cache_enabled'];
        }

        if (isset($options['cache_time'])) {
            $this->cache_time = $options['cache_time'];
        }

        if ((int)$this->cache_time === 0) {
            $this->cache_time = 86400;
        }

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
        return $this;
    }

    /**
     * Create a cache entry
     *
     * @param   string  $key
     * @param   mixed   $value
     * @param   integer $ttl (number of seconds)
     *
     * @return  $this
     * @since   1.0
     */
    public function set($key = null, $value, $ttl = 0)
    {
        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0
     */
    public function remove($key = null)
    {
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
        return $this;
    }
}
