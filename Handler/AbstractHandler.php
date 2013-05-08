<?php
/**
 * Abstract Handler Cache
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Molajo\Cache\CacheItem;
use Molajo\Cache\Api\CacheInterface;
use Molajo\Cache\Exception\AbstractHandlerException;

/**
 * Abstract Handler Cache
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
abstract class AbstractHandler implements CacheInterface
{
    /**
     * Cache Handler
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
    protected $cache_service = false;

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
     * @param  string $cache_handler
     *
     * @since  1.0
     */
    public function __construct($cache_handler = 'AbstractHandler')
    {
        $this->cache_handler = ucfirst(strtolower($cache_handler));
    }

    /**
     * Connect to Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  AbstractHandlerException
     */
    public function connect($options = array())
    {
        $this->cache_service = false;
        if (isset($options['cache_service'])) {
            $this->cache_service = (boolean)$options['cache_service'];
        }

        $this->cache_time = 86400;
        if (isset($options['cache_time'])) {
            $this->cache_time = $options['cache_time'];
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
     * @throws  AbstractHandlerException
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
     * @throws  AbstractHandlerException
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
     * @throws  AbstractHandlerException
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

    /**
     * Get multiple CacheItems by Key
     *
     * @param   array $keys
     *
     * @return  array
     * @since   1.0
     */
    public function getMultiple($keys = array())
    {
        $entries = array();

        if (count($keys) > 0 && is_array($keys)) {
            foreach ($keys as $key) {
                $entries[$key] = $this->get($key);
            }
        }

        return $entries;
    }

    /**
     * Create a set of cache entries
     *
     * @param   array        $items
     * @param   null|integer $ttl
     *
     * @return  $this
     * @since   1.0
     */
    public function setMultiple($items = array(), $ttl = null)
    {
        if (count($items) > 0 && is_array($items)) {

            foreach ($items as $key => $value) {
                $this->set($key, $value, $ttl);
            }
        }

        return $this;
    }

    /**
     * Remove a set of cache entries
     *
     * @param   array $keys
     *
     * @return  $this
     * @since   1.0
     */
    public function removeMultiple($keys = array())
    {
        if (count($keys) > 0 && is_array($keys)) {
            foreach ($keys as $key) {
                $this->remove($key);
            }
        }

        return $this;
    }
}
