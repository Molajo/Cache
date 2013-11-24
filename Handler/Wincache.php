<?php
/**
 * Wincache
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Wincache as phpWincache;
use Exception;
use Exception\Cache\WincacheHandlerException;
use Molajo\Cache\CacheItem;
use CommonApi\Cache\CacheInterface;

/**
 * Wincache Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Wincache extends AbstractHandler implements CacheInterface
{
    /**
     * Wincache Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $wincache;

    /**
     * Constructor
     *
     * @param  string $cache_handler
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'Wincache';

        $this->connect($options);
    }

    /**
     * Connect to Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  WincacheHandlerException
     * @api
     */
    public function connect($options = array())
    {
        parent::connect($options);

        if (extension_loaded('wincache') && is_callable('wincache_ucache_get')) {
        } else {
            throw new WincacheHandlerException
            ('Cache: Wincache not supported.');
        }

        return $this;
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  null|mixed cached value
     * @since   1.0
     * @throws  WincacheHandlerException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {
            $value = \wincache_ucache_get($key);

            if ($value === false) {
                return new CacheItem($key, null, false);
            }
        } catch (Exception $e) {
            throw new WincacheHandlerException
            ('Cache: Get Failed for Wincache Key: ' . $key . ' Message: ' . $e->getMessage());
        }

        return new CacheItem($key, $value, true);
    }

    /**
     * Create a cache entry
     *
     * @param   string  $key
     * @param   mixed   $value
     * @param   integer $ttl (number of seconds)
     *
     * @return  $this
     * @since   1.0
     * @throws  WincacheHandlerException
     */
    public function set($key = null, $value = null, $ttl = 0)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        if ($key === null) {
            $key = serialize($value);
        }

        if ((int)$ttl == 0) {
            $ttl = (int)$this->cache_time;
        }

        $results = wincache_ucache_add($key, $value, (int)$ttl);

        if ($results === true) {
        } else {
            throw new WincacheHandlerException
            ('Cache APC Handler: Set failed for Key: ' . $key);
        }

        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param   string $key
     *
     * @return  object
     * @since   1.0
     * @throws  WincacheHandlerException
     */
    public function remove($key = null)
    {
        try {
            $results = \wincache_ucache_delete($key);

            if ($results === true) {
            } else {
                throw new WincacheHandlerException
                ('Unable to remove cache entry for');
            }
        } catch (Exception $e) {
            throw new WincacheHandlerException
            ('Cache: Get Failed for Wincache ' . $e->getMessage());
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
        try {
            $results = \wincache_ucache_clear();

            if ($results === true) {
            } else {
                throw new WincacheHandlerException('Unable to clear Wincache.');
            }
        } catch (Exception $e) {
            throw new WincacheHandlerException
            ('Unable to clear Wincache.' . $e->getMessage());
        }
    }
}
