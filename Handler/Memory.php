<?php
/**
 * Memory Cache
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Exception;
use Molajo\Cache\CacheItem;
use Molajo\Cache\Api\CacheInterface;
use Molajo\Cache\Exception\MemoryHandlerException;

/**
 * Memory Cache
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Memory extends AbstractHandler implements CacheInterface
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
     * @param  string $cache_handler
     *
     * @since  1.0
     */
    public function __construct($options)
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
     * @throws  MemoryHandlerException
     * @api
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
     * @throws  MemoryHandlerException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {

            $value  = null;
            $exists = false;

            if (isset($this->cache_container[$key])) {
                $entry  = $this->cache_container[$key];
                $exists = true;
                $value  = $entry->value;
            }

            return new CacheItem($key, $value, $exists);

        } catch (Exception $e) {
            throw new MemoryHandlerException
            ('Cache: Memory Handler Failed during Get for Memory ' . $key . $e->getMessage());
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
     * @throws  MemoryHandlerException
     */
    public function set($key = null, $value = null, $ttl = 0)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        if ($key === null) {
            $key = serialize($value);
        }

        if ((int)$ttl == 0) {
            $ttl = (int)$this->cache_time;
        }

        try {
            $entry          = new \stdClass();
            $entry->value   = $value;
            $entry->expires = $ttl;

            $this->cache_container[$key] = $entry;

        } catch (Exception $e) {
            throw new MemoryHandlerException
            ('Cache: Memory Handler Failed during set for Memory');
        }

        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param string $key
     *
     * @return  object
     * @since   1.0
     * @throws  MemoryHandlerException
     */
    public function remove($key = null)
    {
        try {

            if (isset($this->cache_container[$key])) {
                unset($this->cache_container[$key]);
            }

        } catch (Exception $e) {
            throw new MemoryHandlerException
            ('Cache: Memory Handler Failed during Remove ' . $e->getMessage());
        }
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
