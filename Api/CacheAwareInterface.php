<?php
/**
 * Cache Aware Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache\Api;

use Molajo\Cache\Exception\CacheException;

/**
 * Cache Aware Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface CacheAwareInterface
{
    /**
     * Sets a Cache Instance on the object
     *
     * @param   string $key
     *
     * @return  CacheInterface $cache
     * @since   1.0
     * @throws  CacheException
     */
    public function setCache(CacheInterface $cache);
}
