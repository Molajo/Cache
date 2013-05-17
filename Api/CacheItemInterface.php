<?php
/**
 * Cache Item Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache\Api;

use Molajo\Cache\Exception\CacheException;

/**
 * Cache Item Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface CacheItemInterface
{
    /**
     * Get the Key associated with this Cache Item
     *
     * @return  string  $key
     * @since   1.0
     */
    public function getKey();

    /**
     * Get the Value associated with this Cache Item
     *
     * @return  mixed  $key
     * @since   1.0
     */
    public function getValue();

    /**
     * True or false value as to whether or not the item exists in current cache
     *
     * @return  boolean
     * @since   1.0
     */
    public function isHit();
}
