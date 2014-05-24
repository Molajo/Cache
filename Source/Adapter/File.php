<?php
/**
 * File Adapter for Cache
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Adapter;

use Exception;
use DirectoryIterator;
use Molajo\Cache\CacheItem;
use CommonApi\Exception\RuntimeException;
use CommonApi\Cache\CacheInterface;

/**
 * File Adapter for Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class File extends AbstractAdapter implements CacheInterface
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
     * @param  string $cache_handler
     * @param  array  $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'File';

        $this->connect($options);
    }

    /**
     * Connect to the Cache
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

        try {
            $this->cache_folder = null;

            if (isset($options['cache_folder'])) {
                $this->cache_folder = $options['cache_folder'];
            }

            $this->createFolder();

        } catch (Exception $e) {
            throw new RuntimeException(
                'Cache: Failed creating File Adapter Folder ' . $this->cache_folder . $e->getMessage()
            );
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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function get($key)
    {
        if ($this->cache_enabled == 0) {
            return false;
        }

        try {
            list($exists, $value) = $this->getFileContents($key);

        } catch (Exception $e) {
            throw new RuntimeException(
                'Cache: Get Failed for File ' . $this->cache_folder . '/' . $key . $e->getMessage()
            );
        }

        return new CacheItem($key, $value, $exists);
    }

    /**
     * Create a cache entry
     *
     * @param   string       $key   serialize name uniquely identifying content
     * @param   mixed        $value Data to be serialized and then saved as cache
     * @param   null|integer $ttl
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function set($key, $value, $ttl = 0)
    {
        if ($this->cache_enabled == 0) {
            return false;
        }

        if (file_exists($this->cache_folder . '/' . $key) === true) {
            return $this;
        }

        $this->filePut($key, $value);

        $this->chmodFile($key);

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
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function remove($key = null)
    {
        try {
            if (file_exists($this->cache_folder . '/' . $key)) {
                unlink($this->cache_folder . '/' . $key);
            }
        } catch (Exception $e) {
            throw new RuntimeException(
                'Cache: Remove cache entry failed ' . $this->cache_folder . '/' . $key . $e->getMessage()
            );
        }

        return $this;
    }

    /**
     * Close the Connection
     *
     * @return  $this
     * @since   1.0
     */
    public function close()
    {
        return $this;
    }

    /**
     * File Put
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function filePut($key, $value)
    {
        try {
            file_put_contents($this->cache_folder . '/' . $key, serialize($value));
        } catch (Exception $e) {
            throw new RuntimeException(
                'Cache: file_put_contents failed for ' . $this->cache_folder . '/' . $key . $e->getMessage()
            );
        }

        return $this;
    }

    /**
     * Chmod File
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function chmodFile($key)
    {
        try {
            chmod(($this->cache_folder . '/' . $key), 0644);
        } catch (Exception $e) {
            throw new RuntimeException(
                'Cache: Chmod failed ' . $this->cache_folder . '/' . $key . $e->getMessage()
            );
        }

        return $this;
    }

    /**
     * Create Folder
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function createFolder()
    {
        if (is_dir($this->cache_folder) === true) {
        } else {
            mkdir($this->cache_folder);
        }

        return $this;
    }

    /**
     * Get File Contents
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getFileContents($key)
    {
        $exists = false;
        $value  = null;

        if (file_exists($this->cache_folder . '/' . $key) === true) {
            $exists = true;
            $value  = unserialize(file_get_contents($this->cache_folder . '/' . $key));
        }

        return array($exists, $value);
    }
}
