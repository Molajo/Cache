<?php
/**
 * Redis Handler
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Exception;
use Molajo\Cache\CacheItem;
use Molajo\Cache\Api\CacheInterface;
use Molajo\Cache\Exception\RedisHandlerException;

/**
 * Redis Handler
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Redis extends AbstractHandler implements CacheInterface
{
    /**
     * Redis Database Connection
     *
     * @var    object
     *
     * @since  1.0
     */
    protected $redis;

    /**
     * Constructor
     *
     * @param   string $cache_handler
     *
     * @since   1.0
     */
    public function __construct($cache_handler = 'Redis')
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
     * @throws  RedisHandlerException
     * @api
     */
    public function connect($options = array())
    {
        if (isset($options['redis'])) {
            $this->redis = $options['redis'];
        } else {
            throw new RedisHandlerException
            ('Cache Redis Handler: Redis Database dependency not passed into Connect');
        }

        return parent::connect($options);
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  bool|CacheItem
     * @since   1.0
     * @throws  RedisHandlerException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {
            $value = $this->redis->get($key);

            $exists = (boolean)$value;

            return new CacheItem($key, $value, $exists);

        } catch (Exception $e) {
            throw new RedisHandlerException
            ('Cache: Get Failed for Redis ' . $e->getMessage());
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
     * @throws  RedisHandlerException
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

        $results = $this->redis->set($key, $value);

        $results = $this->redis->expire($key, $ttl);

        if ($results === false) {
            throw new RedisHandlerException
            ('Cache APC Handler: Set failed for Key: ' . $key);
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
     * @throws  RedisHandlerException
     */
    public function remove($key = null)
    {
        $results = $this->redis->del($key);

        if ($results === false) {
            throw new RedisHandlerException
            ('Cache: Remove cache entry failed');
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
        $this->redis->flushdb();

        return $this;
    }
}
