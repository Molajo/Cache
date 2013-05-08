<?php
/**
 * Cache Item
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache;

use Molajo\Cache\Api\CacheItemInterface;

/**
 * Cache Item Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Class CacheItem implements CacheItemInterface
{
    /**
     * Cache Key
     *
     * @var     string
     * @since   1.0
     */
    public $key;

    /**
     * Cache Hit
     *
     * @var     bool
     * @since   1.0
     */
    public $isHit;

    /**
     * Cache Value
     *
     * @var     mixed
     * @since   1.0
     */
    public $value;

    /**
     * Constructor
     *
     * @param  string $key
     * @param  null   $value
     * @param  bool   $isHit
     *
     * @since  1.0
     */
    public function __construct($key, $value = null, $isHit = true)
    {
        $this->key   = $key;
        $this->value = $value;
        $this->isHit = $isHit;
    }

    /**
     * Get the Key associated with this Cache Item
     *
     * @return  string  $key
     * @since   1.0
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the Value associated with this Cache Item
     *
     * @return  mixed
     * @since   1.0
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the Value associated with this Cache Item
     *
     * @param   null|mixed $value
     *
     * @return  $this
     * @since   1.0
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * True or false value as to whether or not the item exists in current cache
     *
     * @return  bool
     * @since   1.0
     */
    public function isHit()
    {
        return (bool)$this->isHit;
    }
}
