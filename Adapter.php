<?php
/**
 * Adapter for Cache
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache;

defined('MOLAJO') or die;

use Exception;
use Molajo\Cache\Exception\CacheException;
use Molajo\Cache\Adapter\CacheInterface;

/**
 * Adapter for Cache
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @since     1.0
 */
Class Adapter implements CacheInterface
{
    /**
     * Cache Type
     *
     * @var     object
     * @since   1.0
     */
    public $ct;

    /**
     * Initialise Cache when activated
     *
     * @param   int    $cache_service
     * @param   string $cache_folder
     * @param   int    $cache_time
     * @param   string $cache_type
     *
     * @return  bool|CacheInterface
     * @since   1.0
     * @throws  CacheException
     */
    public function __construct($cache_service = 1, $cache_folder = 'Cache', $cache_time = 900, $cache_type = 'File')
    {
        $cache_type = 'Molajo\\Cache\\Type\\' . ucfirst(strtolower($cache_type)) . 'Cache';

        try {
            $this->ct = new $cache_type($cache_service, $cache_folder, $cache_time, $cache_type);

        } catch (Exception $e) {
            throw new CacheException
            ('Cache: new instance failed ' . $cache_type . $e->getMessage());
        }

        return $this;
    }

    /**
     * Return cached or parameter value
     *
     * @param   string $key      md5 name uniquely identifying content
     *
     * @return  bool|mixed       cache for this key that has not been serialized
     * @since   1.0
     * @throws  CacheException
     */
    public function get($key)
    {
        return $this->ct->get($key);
    }

    /**
     * Create a cache entry or set a parameter value
     *
     * @param   string       $key    md5 name uniquely identifying content
     * @param   mixed        $value  Data to be serialized and then saved as cache
     * @param   null|integer $ttl
     *
     * @return  object      CacheInterface
     * @since   1.0
     * @throws  CacheException
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->ct->set($key, $value, $ttl);
    }

    /**
     * Remove cache if it has expired
     *
     * @return  bool    true (expired) false (did not expire)
     * @since   1.0
     */
    public function removeExpired()
    {
        return $this->ct->removeExpired();
    }

    /**
     * Clear all cache
     *
     * @return  object  CacheInterface
     * @since   1.0
     */
    public function clear()
    {
        return $this->ct->clear();
    }

    /**
     * Remove cache for specified $key value
     *
     * @param   string  $key  md5 name uniquely identifying content
     *
     * @return  object  CacheInterface
     * @since   1.0
     * @throws  CacheException
     */
    public function remove($key = null)
    {
        return $this->ct->remove($key);
    }
}
