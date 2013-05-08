<?php
/**
 * Dummy
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;



use Molajo\Cache\CacheItem;
use Molajo\Cache\Api\CacheInterface;
use Molajo\Cache\Exception\DummyHandlerException;

/**
 * Dummy Cache
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class Dummy extends AbstractHandler implements CacheInterface
{
    /**
     * Constructor
     *
     * @param   string $cache_handler
     *
     * @since   1.0
     */
    public function __construct($cache_handler = 'Dummy')
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
     * @throws  DummyHandlerException
     * @api
     */
    public function connect($options = array())
    {
        return parent::connect($options);
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  bool|CacheItem
     * @since   1.0
     * @throws  DummyHandlerException
     */
    public function get($key)
    {
        return $this;
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
     * @throws  DummyHandlerException
     */
    public function set($key = null, $value = null, $ttl = 0)
    {
        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param string $key
     *
     * @return  object
     * @since   1.0
     * @throws  DummyHandlerException
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
