<?php
/**
 * Adapter for Cache
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache;

use Exception;
use Molajo\Cache\Exception\AdapterException;
use Molajo\Cache\Api\CacheInterface;

/**
 * Adapter for Cache
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @since     1.0
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
     * @param   array          $options
     *
     * @since   1.0
     */
    public function __construct(CacheInterface $cache, $options)
    {
        $this->adapterHandler = $cache;
        $this->connect($options);
    }

    /**
     * Connect to the Cache Adapter Handler
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  AdapterException
     * @api
     */
    public function connect($options = array())
    {
        try {
            $this->adapterHandler->connect($options);

        } catch (Exception $e) {

            throw new AdapterException
            ('Cache: Caught Exception: ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * Return cached or parameter value
     *
     * @param  string $key md5 name uniquely identifying content
     *
     * @return  bool|CacheItem cache for this key that has not been serialized
     * @since   1.0
     * @throws  AdapterException
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
     * @throws  AdapterException
     */
    public function set($key = null, $value, $ttl = 0)
    {
        return $this->adapterHandler->set($key, $value, $ttl);
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

    /**
     * Remove cache for specified $key value
     *
     * @param string $key md5 name uniquely identifying content
     *
     * @return  object CacheInterface
     * @since   1.0
     * @throws  AdapterException
     */
    public function remove($key = null)
    {
        return $this->adapterHandler->remove($key);
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
        return $this->adapterHandler->getMultiple($keys);
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
        return $this->adapterHandler->setMultiple($items, $ttl);
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
        return $this->adapterHandler->removeMultiple($keys);
    }
}
