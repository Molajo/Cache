<?php
/**
 * XCache
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use XCache as phpXCache;
use Exception;
use Molajo\Cache\Exception\XCacheHandlerException;
use Molajo\Cache\Api\CacheInterface;

/**
 * XCache Cache
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class XCache extends AbstractHandler implements CacheInterface
{
    /**
     * Constructor
     *
     * @param  string $cache_handler
     *
     * @since  1.0
     */
    public function __construct($cache_handler = 'XCache')
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
     * @throws  XCacheHandlerException
     * @api
     */
    public function connect($options = array())
    {
        parent::connect($options);

        if (extension_loaded('xcache') && is_callable('xcache_get')) {
        } else {
            throw new XCacheHandlerException
            ('Cache XCache Handler: Not supported. xcache must be loaded and xcache_get must be callable.');
        }

        $pool = null;
        if (isset($options['xcache_pool'])) {
            $pool = $options['xcache_pool'];
        }

        $compression = false;
        if (isset($options['xcache_compression'])) {
            $compression = $options['xcache_compression'];
        }

        $servers = array();
        if (isset($options['xcache_servers'])) {
            $servers = $options['xcache_servers'];
        }

        $this->xcache = new phpXCache($pool);

        $this->xcache->setOption(phpXCache::OPT_COMPRESSION, $compression);
        $this->xcache->setOption(phpXCache::OPT_LIBKETAMA_COMPATIBLE, true);

        $serverList = $this->xcache->getServerList();
        if (empty($serverList)) {
            foreach ($servers as $server) {
                $this->xcache->addServer($server->host, $server->port);
            }
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
     * @throws  XCacheHandlerException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {
            $value = $this->xcache->get($key);

            $results = $this->xcache->getResultCode();

            if (phpXCache::RES_SUCCESS == $results) {
                $exists = true;

            } elseif (phpXCache::RES_NOTFOUND == $results) {
                $exists  = false;
                $results = null;

            } else {
                throw new XCacheHandlerException
                (sprintf(
                    'Unable to fetch cache entry for %s. Error message `%s`.',
                    $key,
                    $this->xcache->getResultMessage()
                ));
            }

        } catch (Exception $e) {
            throw new XCacheHandlerException
            ('Cache: Get Failed for XCache ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        return new CacheItem($key, $value, $exists);
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
     * @throws  XCacheHandlerException
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


        $results = apc_store($key, $value, (int)$ttl);

        $this->xcache->set($key, $value, (int)$ttl);

        $results = $this->xcache->getResultCode();

        if (phpXCache::RES_SUCCESS == $results) {
        } else {
            throw new XCacheHandlerException
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
     * @throws  XCacheHandlerException
     */
    public function remove($key = null)
    {
        try {
            $this->xcache->delete($key);

            $results = $this->xcache->getResultCode();

            if (phpXCache::RES_SUCCESS == $results) {

            } elseif (phpXCache::RES_NOTFOUND == $results) {

            } else {
                throw new XCacheHandlerException
                (sprintf(
                    'Unable to remove cache entry for %s. Error message `%s`.',
                    $key,
                    $this->xcache->getResultMessage()
                ));
            }

        } catch (Exception $e) {
            throw new XCacheHandlerException
            ('Cache: Get Failed for XCache ' . $this->cache_folder . '/' . $key . $e->getMessage());
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
            $this->xcache->flush();

            $results = $this->xcache->getResultCode();

            if (phpXCache::RES_SUCCESS == $results) {

            } elseif (phpXCache::RES_NOTFOUND == $results) {

            } else {
                throw new XCacheHandlerException('Unable to flush XCache.');
            }

        } catch (Exception $e) {
            throw new XCacheHandlerException
            ('Cache: Flush Failed for XCache ' . $e->getMessage());
        }
    }
}
