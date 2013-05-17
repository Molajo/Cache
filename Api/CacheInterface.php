<?php
/**
 * Cache Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache\Api;

use Molajo\Cache\Exception\CacheException;

/**
 * Cache Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface CacheInterface
{
    /**
     * Retrieve cache value
     *
     * @param   string $key
     *
     * @return  bool
     * @since   1.0
     * @throws  CacheException
     */
    public function get($key);

    /**
     * Persist data in cache
     *
     * @param   string  $key
     * @param   mixed   $value
     * @param   integer $ttl (number of seconds)
     *
     * @return  bool
     * @since   1.0
     * @throws  CacheException
     */
    public function set($key = null, $value, $ttl = 0);

    /**
     * Delete cache for specified $key value or expired cache
     *
     * @param   string $key
     *
     * @return  bool
     * @since   1.0
     * @throws  CacheException
     */
    public function remove($key = null);

    /**
     * Clear all cache
     *
     * @return  bool
     * @since   1.0
     */
    public function clear();

    /**
     * Get multiple CacheItems by Key
     *
     * @param   array $keys
     *
     * @return  array
     * @since   1.0
     */
    public function getMultiple($keys = array());

    /**
     * Create a set of cache entries
     *
     * @param   array        $items
     * @param   null|integer $ttl
     *
     * @return  $this
     * @since   1.0
     */
    public function setMultiple($items = array(), $ttl = null);

    /**
     * Remove a set of cache entries
     *
     * @param   array $keys
     *
     * @return  $this
     * @since   1.0
     */
    public function removeMultiple($keys = array());
}
