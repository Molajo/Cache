<?php
/**
 * Dummy Cache
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Adapter;

use CommonApi\Cache\CacheInterface;

/**
 * Dummy Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Dummy extends AbstractAdapter implements CacheInterface
{
    /**
     * @covers  Molajo\Cache\Adapter\Dummy::__construct
     * @covers  Molajo\Cache\Adapter\Dummy::connect
     * @covers  Molajo\Cache\Adapter\Dummy::get
     * @covers  Molajo\Cache\Adapter\Dummy::set
     * @covers  Molajo\Cache\Adapter\Dummy::remove
     * @covers  Molajo\Cache\Adapter\Dummy::clear
     *
     * @since   1.0
     */
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'Dummy';

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

        return $this;
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  Dummy
     * @since   1.0
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
     */
    public function set($key, $value = null, $ttl = 0)
    {
        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param string $key
     *
     * @return  Dummy
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

    /**
     * Get File Contents
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0
     */
    protected function createCacheItem($key)
    {
        return array(null, null);
    }
}
