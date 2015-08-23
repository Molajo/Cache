<?php
/**
 * File Adapter for Cache
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Adapter;

use DirectoryIterator;
use Molajo\Cache\CacheItem;
use CommonApi\Cache\CacheInterface;

/**
 * File Adapter for Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
final class File extends AbstractAdapter implements CacheInterface
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
     * @param  array $options
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
     * @since   1.0.0
     */
    public function connect($options = array())
    {
        parent::connect($options);

        $this->cache_folder = null;

        if (isset($options['cache_folder'])) {
            $this->cache_folder = $options['cache_folder'];
        }

        $this->createFolder();

        return $this;
    }

    /**
     * Return cached value
     *
     * @param   string $key
     *
     * @return  bool|CacheItem
     * @since   1.0.0
     */
    public function get($key)
    {
        return parent::get($key);
    }

    /**
     * Create a cache entry
     *
     * @param   string  $key   serialize name uniquely identifying content
     * @param   mixed   $value Data to be serialized and then saved as cache
     * @param   integer $ttl
     *
     * @return  $this
     * @since   1.0.0
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
     * Clear all cache
     *
     * @return  $this
     * @since   1.0.0
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
     * @since   1.0.0
     */
    public function remove($key = null)
    {
        if (file_exists($this->cache_folder . '/' . $key)) {
            unlink($this->cache_folder . '/' . $key);
        }

        return $this;
    }

    /**
     * Close the Connection
     *
     * @return  $this
     * @since   1.0.0
     */
    public function close()
    {
        return $this;
    }

    /**
     * Remove cache if it has expired
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function removeExpired()
    {
        foreach (new DirectoryIterator($this->cache_folder) as $file) {

            if ($file->isDot()) {
            } else {
                $this->removeExpiredFile($file);
            }
        }

        return $this;
    }

    /**
     * File Put
     *
     * @param   string $key
     * @param   mixed  $value
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function filePut($key, $value)
    {
        file_put_contents($this->cache_folder . '/' . $key, serialize($value));

        return $this;
    }

    /**
     * Chmod File
     *
     * @param   string $key
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function chmodFile($key)
    {
        chmod(($this->cache_folder . '/' . $key), 0644);

        return $this;
    }

    /**
     * Create Folder
     *
     *
     * @return  $this
     * @since   1.0.0
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
     * @since   1.0.0
     */
    protected function createCacheItem($key)
    {
        $exists = false;
        $value  = null;

        if (file_exists($this->cache_folder . '/' . $key) === true) {
            $exists = true;
            $value  = unserialize(file_get_contents($this->cache_folder . '/' . $key));
        }

        return array($value, $exists);
    }

    /**
     * Remove expired file
     *
     *
     * @param DirectoryIterator $file
     *
     * @return  $this
     * @since   1.0.0
     */
    protected function removeExpiredFile($file)
    {
        if (file_exists($file->getPathname())
            && (time() - $this->cache_time)
            < filemtime($file->getPathname())
        ) {
        } else {
            $this->remove($file->getPathname());
        }
    }
}
