<?php
/**
 * File
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Exception;
use DirectoryIterator;
use Molajo\Cache\CacheItem;
use Molajo\Cache\Exception\FileHandlerException;
use Molajo\Cache\Api\CacheInterface;

/**
 * File Cache
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class File extends AbstractHandler implements CacheInterface
{
    /**
     * Cache Path from Root
     *
     * @var    string
     * @since  1.0
     */
    protected $cache_folder;

    /**
     * Constructor
     *
     * @param   string $cache_handler
     *
     * @since   1.0
     */
    public function __construct($cache_handler = 'File')
    {
        parent::__construct($cache_handler);
    }

    /**
     * Connect to the Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  FileHandlerException
     * @api
     */
    public function connect($options = array())
    {
        parent::connect($options);

        try {
            $this->cache_folder = null;

            if (isset($options['cache_folder'])) {
                $this->cache_folder = $options['cache_folder'];
            }

            if (is_dir($this->cache_folder) === true) {
            } else {
                mkdir($this->cache_folder);
            }

        } catch (Exception $e) {
            throw new FileHandlerException
            ('Cache: Failed creating File Handler Folder ' . $this->cache_folder . $e->getMessage());
        }

        return $this;
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  bool|CacheItem
     * @since   1.0
     * @throws  FileHandlerException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {

            $exists = false;
            $value  = null;

            if (file_exists($this->cache_folder . '/' . $key) === true) {
                $exists = true;
                $value  = unserialize(file_get_contents($this->cache_folder . '/' . $key));
            }

        } catch (Exception $e) {
            throw new FileHandlerException
            ('Cache: Get Failed for File ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        return new CacheItem($key, $value, $exists);
    }

    /**
     * Create a cache entry
     *
     * @param   string       $key   md5 name uniquely identifying content
     * @param   mixed        $value Data to be serialized and then saved as cache
     * @param   null|integer $ttl
     *
     * @return  $this
     * @since   1.0
     * @throws  FileHandlerException
     */
    public function set($key = null, $value, $ttl = 0)
    {
        if ($this->cache_service == 0) {
            throw new FileHandlerException
            ('Cache: Not enabled by the application.');
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
            throw new FileHandlerException
            ('Cache: Set file exists check Failed for File ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        try {
            file_put_contents($this->cache_folder . '/' . $key, serialize($value));

        } catch (Exception $e) {
            throw new FileHandlerException
            ('Cache: file_put_contents failed for ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        try {
            chmod(($this->cache_folder . '/' . $key), 0644);

        } catch (Exception $e) {
            throw new FileHandlerException
            ('Cache: Chmod failed ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        return $this;
    }

    /**
     * Remove cache if it has expired
     *
     * @return  $this
     * @since   1.0
     */
    protected function removeExpired()
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
     * @return  $this
     * @since   1.0
     */
    public function clear()
    {
        foreach (new DirectoryIterator($this->cache_folder) as $file) {
            if ($file->isDot()) {
            } else {
                $this->remove($file->getBasename());
            }
        }

        return $this;
    }

    /**
     * Remove cache for specified $key value
     *
     * @param string $key
     *
     * @return  $this
     * @since   1.0
     * @throws  FileHandlerException
     */
    public function remove($key = null)
    {
        try {
            if (file_exists($this->cache_folder . '/' . $key)) {
                unlink($this->cache_folder . '/' . $key);
            }
        } catch (Exception $e) {
            throw new FileHandlerException
            ('Cache: Remove file failed ' . $this->cache_folder . '/' . $key . $e->getMessage());
        }

        return $this;
    }

    /**
     * Close the Connection
     *
     * @return  $this
     * @since   1.0
     * @throws  FileHandlerException
     * @api
     */
    public function close()
    {
        return $this;
    }
}
