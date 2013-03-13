<?php
/**
 * FileCache
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Type;

defined('MOLAJO') or die;

use DirectoryIterator;
use Exception;
use Molajo\Cache\Exception\CacheException;
use Molajo\Cache\Adapter\CacheInterface;

/**
 * File Cache
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Class FileCache implements CacheInterface
{
    /**
     * Cache Type
     *
     * @var    string
     * @since  1.0
     */
    protected $cache_type = 'File';

    /**
     * Cache
     *
     * @var    string
     * @since  1.0
     */
    protected $cache_service = false;

    /**
     * Cache Path
     *
     * @var    string
     * @since  1.0
     */
    protected $cache_folder = 'Cache';

    /**
     * Cache Handler
     *
     * @var    string
     * @since  1.0
     */
    protected $cache_handler = '';

    /**
     * Cache Time
     *
     * @var    Integer
     * @since  1.0
     */
    protected $cache_time = 900;

    /**
     * Initialise Cache when activated
     *
     * @param   int    $cache_service
     * @param   string $cache_folder
     * @param   int    $cache_time
     *
     * @return  bool|Cache
     * @since   1.0
     * @throws  CacheException
     */
    public function __construct($cache_service = 1, $cache_folder = 'Cache', $cache_time = 900, $cache_type = 'File')
    {
        $cache_type = ucfirst(strtolower($cache_type));

        if ((int) $cache_service === 0) {
            $this->cache_service = 0;
            return $this;
        }

        $this->cache_service = 1;

        $this->cache_folder = $cache_folder;

        if (is_dir($this->cache_folder)) {

        } else {

            try {
                mkdir($this->cache_folder);
            } catch (Exception $e) {
                throw new CacheException
                ('Cache: mkdir failed ' . $this->cache_folder . $e->getMessage());
            }

            try {
                chmod(($this->cache_folder), 0755);
            } catch (Exception $e) {
                throw new CacheException
                ('Cache: Chmod failed ' . $this->cache_folder . $e->getMessage());
            }
        }

        $this->cache_time = (int) $cache_time;
        if ((int) $this->cache_time === 0) {
            $this->cache_service = 900;
        }

        $this->removeExpired();

        return $this;
    }

    /**
     * Return cached or parameter value
     *
     * @param   string $key      md5 name uniquely identifying content
     *
     * @return  bool|mixed        cache for this key that has not been serialized
     * @since   1.0
     * @throws  CacheException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {
            if (file_exists($this->cache_folder . '/' . $key) === true) {
                return unserialize(file_get_contents($this->cache_folder . '/' . $key));
            }
        } catch (Exception $e) {
            throw new CacheException
            ('Cache: Get Failed for File ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }
    }

    /**
     * Create a cache entry or set a parameter value
     *
     * @param   string       $key    md5 name uniquely identifying content
     * @param   mixed        $value  Data to be serialized and then saved as cache
     * @param   null|integer $ttl
     *
     * @return  bool|Cache
     * @since   1.0
     * @throws  CacheException
     */
    public function set($key = null, $value, $ttl = null)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        if ($key === null) {
            $key = md5($value);
        }

        if (file_exists($this->cache_folder . '/' . $key) === true) {
            return $this;
        }

        try {
            if (file_exists($this->cache_folder . '/' . $key) === true) {
                return $this;
            }
        } catch (Exception $e) {
            throw new CacheException
            ('Cache: Set file exists check Failed for File ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        try {
            file_put_contents($this->cache_folder . '/' . $key, serialize($value));
        } catch (Exception $e) {
            throw new CacheException
            ('Cache: file_put_contents failed for ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        try {
            chmod(($this->cache_folder . '/' . $key), 0644);
        } catch (Exception $e) {
            throw new CacheException
            ('Cache: Chmod failed ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        return $this;
    }

    /**
     * Remove cache if it has expired
     *
     * @return  bool    true (expired) false (did not expire)
     * @since   1.0
     */
    public function removeExpired()
    {
        foreach (new DirectoryIterator($this->cache_folder) as $file) {

            if ($file->isDot()) {
            } else {

                if (file_exists($file->getPathname())) {
                } else {
                    $this->remove($file->getPathname());
                }

                if (file_exists($file->getPathname())
                    && (time() - $this->cache_time)
                        < filemtime($file->getPathname())
                ) {

                } else {
                    $this->remove($file->getPathname());
                }
            }
        }

        return $this;
    }

    /**
     * Clear all cache
     *
     * @return  Cache
     * @since   1.0
     */
    public function clear()
    {
        foreach (new DirectoryIterator($this->cache_folder) as $file) {
            if ($file->isDot()) {
            } else {
                $this->remove($file->getPathname());
            }
        }

        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param   string $key  md5 name uniquely identifying content
     *
     * @return  object
     * @since   1.0
     * @throws  CacheException
     */
    public function remove($key = null)
    {
        try {
            if (file_exists($this->cache_folder . '/' . $key)) {
                unlink($this->cache_folder . '/' . $key);
            }
        } catch (Exception $e) {
            throw new CacheException
            ('Cache: Remove file failed ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        return $this;
    }
}
