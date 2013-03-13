<?php
/**
 * Cache Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache\Adapter;

defined('MOLAJO') or die;

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
     * @param   string       $key
     * @param   mixed        $value
     * @param   null|integer $ttl
     *
     * @return  bool
     * @since   1.0
     * @throws  CacheException
     */
    public function set($key, $value, $ttl = null);

    /**
     * Clear all cache
     *
     * @return  bool
     * @since   1.0
     */
    public function clear();

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
}
