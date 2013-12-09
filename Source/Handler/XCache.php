<?php
/**
 * Xcache
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\Cache\CacheInterface;

/**
 * Xcache Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Xcache extends AbstractHandler implements CacheInterface
{
    /**
     * Constructor
     *
     * @param  string $cache_handler
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'Xcache';

        $this->connect($options);
    }

    /**
     * Connect to Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function connect($options = array())
    {
        parent::connect($options);

        if (extension_loaded('xcache') && is_callable('xcache_get')) {
        } else {
            throw new RuntimeException
            ('Cache Xcache Handler: Not supported. xcache must be loaded and xcache_get must be callable.');
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

        $this->xcache = new phpXcache($pool);

        $this->xcache->setOption(phpXcache::OPT_COMPRESSION, $compression);
        $this->xcache->setOption(phpXcache::OPT_LIBKETAMA_COMPATIBLE, true);

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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {
            $value = $this->xcache->get($key);

            $results = $this->xcache->getResultCode();

            if (phpXcache::RES_SUCCESS == $results) {
                $exists = true;
            } elseif (phpXcache::RES_NOTFOUND == $results) {
                $exists  = false;
                $results = null;
            } else {
                throw new RuntimeException
                (sprintf(
                    'Unable to fetch cache entry for %s. Error message `%s`.',
                    $key,
                    $this->xcache->getResultMessage()
                ));
            }
        } catch (Exception $e) {
            throw new RuntimeException
            ('Cache: Get Failed for Xcache ' . $this->cache_folder . '/' . $key . $e->getMessage());
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
     * @throws  \CommonApi\Exception\RuntimeException
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

        if (phpXcache::RES_SUCCESS == $results) {
        } else {
            throw new RuntimeException
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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function remove($key = null)
    {
        try {
            $this->xcache->delete($key);

            $results = $this->xcache->getResultCode();

            if (phpXcache::RES_SUCCESS == $results) {
            } elseif (phpXcache::RES_NOTFOUND == $results) {
            } else {
                throw new RuntimeException
                (sprintf(
                    'Unable to remove cache entry for %s. Error message `%s`.',
                    $key,
                    $this->xcache->getResultMessage()
                ));
            }
        } catch (Exception $e) {
            throw new RuntimeException
            ('Cache: Get Failed for Xcache ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        return $this;
    }

    /**
     * Clear all cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function clear()
    {
        try {
            $this->xcache->flush();

            $results = $this->xcache->getResultCode();

            if (phpXcache::RES_SUCCESS == $results) {
            } elseif (phpXcache::RES_NOTFOUND == $results) {
            } else {
                throw new RuntimeException('Unable to flush Xcache.');
            }
        } catch (Exception $e) {
            throw new RuntimeException
            ('Cache: Flush Failed for Xcache ' . $e->getMessage());
        }
    }
}
