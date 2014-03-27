<?php
/**
 * Redis Adapter
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Adapter;

use Exception;
use Molajo\Cache\CacheItem;
use CommonApi\Cache\CacheInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Redis Adapter
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Redis extends AbstractAdapter implements CacheInterface
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
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'Redis';

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

        if (isset($options['redis'])) {
            $this->redis = $options['redis'];
        } else {
            throw new RuntimeException
            ('Cache Redis Adapter: Redis Database dependency not passed into Connect');
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
            $value = $this->redis->get($key);

            $exists = (boolean)$value;

            return new CacheItem($key, $value, $exists);
        } catch (Exception $e) {
            throw new RuntimeException
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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function set($key = null, $value = null, $ttl = 0)
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

        $this->redis->set($key, $value);

        $results = $this->redis->expire($key, $ttl);

        if ($results === false) {
            throw new RuntimeException
            ('Cache APC Adapter: Set failed for Key: ' . $key);
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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function remove($key = null)
    {
        $results = $this->redis->del($key);

        if ($results === false) {
            throw new RuntimeException
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
