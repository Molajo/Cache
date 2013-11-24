<?php
/**
 * Database Cache Handler
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Handler;

use Exception;
use Molajo\Cache\CacheItem;
use Exception\Cache\DatabaseHandlerException;
use CommonApi\Cache\CacheInterface;

/**
 * Database Cache
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Database extends AbstractHandler implements CacheInterface
{
    /**
     * Database Connection
     *
     * @var    object
     * @since  1.0
     */
    protected $db_adapter;

    /**
     * Database Table
     *
     * @var    object
     * @since  1.0
     */
    protected $database_table = 'molajo_cache';

    /**
     * Constructor
     *
     * @param   array $options
     *
     * @since   1.0
     */
    public function __construct(array $options = array())
    {
        $this->cache_handler = 'Database';

        $this->connect($options);
    }

    /**
     * Connect to Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  DatabaseHandlerException
     */
    public function connect($options = array())
    {
        parent::connect($options);

        $this->cache_time = 86400;
        if (isset($options['cache_time'])) {
            $this->cache_time = $options['cache_time'];
        }

        $this->db_adapter = null;
        if (isset($options['db_adapter'])) {
            $this->db_adapter = $options['db_adapter'];
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
     * @throws  DatabaseHandlerException
     */
    public function get($key)
    {
        if ($this->cache_service == 0) {
            return false;
        }

        try {

            $sql = 'SELECT '
                . $this->quoteName('value') . ', '
                . $this->quoteName('ttl')
                . ' FROM '
                . $this->quoteName($this->database_table)
                . ' WHERE '
                . $this->quoteName('key')
                . ' = '
                . $this->quote($key);

            $this->setQuery($sql);

            $value = $this->execute();

            if ($value === false) {
                $exists = false;
                $value  = null;
            } else {
                $exists = true;
            }

            return new CacheItem($key, $value, $exists);
        } catch (Exception $e) {
            throw new DatabaseHandlerException
            ('Cache: Get Failed for Database ' . $this->db_adapter . '/' . $key . $e->getMessage());
        }
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
     * @throws  DatabaseHandlerException
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

        $cacheItem = $this->get($key);

        if ($cacheItem->isHit() === false) {
            $this->delete($key);
        } elseif ($cacheItem->geValue() == $value) {
            return $this;
        }

        try {

            $sql = 'INSERT INTO '
                . $this->quoteName($this->database_table)
                . ' ('
                . $this->quoteName('key') . ', '
                . $this->quoteName('value') . ', '
                . $this->quoteName('ttl')
                . ' )'
                . ' VALUES ( '
                . $this->quoteName('key') . ', '
                . $this->quoteName('value') . ', '
                . $this->quoteName('ttl')
                . ' ) ';

            $this->setQuery($sql);

            $value = $this->execute();

            if ($value === false) {
                $exists = false;
                $value  = null;
            } else {
                $exists = true;
            }

            new CacheItem($key, $value, $exists);
        } catch (Exception $e) {
            throw new DatabaseHandlerException
            ('Cache: Get Failed for Database ' . $this->db_adapter . '/' . $key . $e->getMessage());
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
     * @throws  DatabaseHandlerException
     */
    public function remove($key = null)
    {
        try {

            $sql = 'DELETE FROM '
                . $this->quoteName($this->database_table)
                . ' WHERE '
                . $this->quoteName('key') . ' = '
                . $this->quote($key);

            $this->setQuery($sql);

            $this->execute();
        } catch (Exception $e) {
            throw new DatabaseHandlerException
            ('Cache Database Handler: Delete failed' . $e->getMessage());
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
        $sql = 'TRUNCATE TABLE ';
        $sql .= $this->quoteName($this->database_table);

        $this->setQuery($sql)->execute();

        return $this;
    }
}
