<?php
/**
 * Cache Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

use Molajo\Cache\Adapter\File as FileCache;
use Molajo\Cache\Driver;

/**
 * Cache Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Adapter
     *
     * @var    object  Molajo/Cache/Adapter
     * @since  1.0
     */
    protected $adapter;

    /**
     * Options
     *
     * @var    array
     * @since  1.0
     */
    protected $options;

    /**
     * @covers  Molajo\Cache\Adapter\File::__construct
     * @covers  Molajo\Cache\Adapter\File::connect
     * @covers  Molajo\Cache\Adapter\File::get
     * @covers  Molajo\Cache\Adapter\File::set
     * @covers  Molajo\Cache\Adapter\File::remove
     * @covers  Molajo\Cache\Adapter\File::removeExpired
     * @covers  Molajo\Cache\Adapter\File::clear
     * @covers  Molajo\Cache\Adapter\File::close
     * @covers  Molajo\Cache\Adapter\File::filePut
     * @covers  Molajo\Cache\Adapter\File::chmodFile
     * @covers  Molajo\Cache\Adapter\File::createFolder
     * @covers  Molajo\Cache\Adapter\File::getFileContents
     *
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::__construct
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::connect
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::get
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::set
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::remove
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::clear
     *
     * @covers  Molajo\Cache\Driver::__construct
     * @covers  Molajo\Cache\Driver::get
     * @covers  Molajo\Cache\Driver::set
     * @covers  Molajo\Cache\Driver::remove
     * @covers  Molajo\Cache\Driver::clear
     *
     * @covers  Molajo\Cache\CacheItem::__construct
     * @covers  Molajo\Cache\CacheItem::getKey
     * @covers  Molajo\Cache\CacheItem::getValue
     * @covers  Molajo\Cache\CacheItem::setValue
     * @covers  Molajo\Cache\CacheItem::isHit
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->options                  = array();
        $this->options['cache_enabled'] = true;
        $this->options['cache_folder']  = __DIR__ . '/Cache';
        $this->options['cache_time']    = 600; //ten minutes
        $this->options['cache_handler'] = 'File';

        $adapter_handler = new FileCache($this->options);

        $this->adapter = new Driver($adapter_handler);

        return $this;
    }

    /**
     * @covers  Molajo\Cache\Adapter\File::__construct
     * @covers  Molajo\Cache\Adapter\File::connect
     * @covers  Molajo\Cache\Adapter\File::get
     * @covers  Molajo\Cache\Adapter\File::set
     * @covers  Molajo\Cache\Adapter\File::remove
     * @covers  Molajo\Cache\Adapter\File::removeExpired
     * @covers  Molajo\Cache\Adapter\File::clear
     * @covers  Molajo\Cache\Adapter\File::close
     * @covers  Molajo\Cache\Adapter\File::filePut
     * @covers  Molajo\Cache\Adapter\File::chmodFile
     * @covers  Molajo\Cache\Adapter\File::createFolder
     * @covers  Molajo\Cache\Adapter\File::getFileContents
     *
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::__construct
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::connect
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::get
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::set
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::remove
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::clear
     *
     * @covers  Molajo\Cache\Driver::__construct
     * @covers  Molajo\Cache\Driver::get
     * @covers  Molajo\Cache\Driver::set
     * @covers  Molajo\Cache\Driver::remove
     * @covers  Molajo\Cache\Driver::clear
     *
     * @covers  Molajo\Cache\CacheItem::__construct
     * @covers  Molajo\Cache\CacheItem::getKey
     * @covers  Molajo\Cache\CacheItem::getValue
     * @covers  Molajo\Cache\CacheItem::setValue
     * @covers  Molajo\Cache\CacheItem::isHit
     *
     * @return  $this
     * @since   1.0
     */
    public function testConnect()
    {
        $this->assertTrue(file_exists($this->options['cache_folder']));

        return $this;
    }

    /**
     * @covers  Molajo\Cache\Adapter\File::__construct
     * @covers  Molajo\Cache\Adapter\File::connect
     * @covers  Molajo\Cache\Adapter\File::get
     * @covers  Molajo\Cache\Adapter\File::set
     * @covers  Molajo\Cache\Adapter\File::remove
     * @covers  Molajo\Cache\Adapter\File::removeExpired
     * @covers  Molajo\Cache\Adapter\File::clear
     * @covers  Molajo\Cache\Adapter\File::close
     * @covers  Molajo\Cache\Adapter\File::filePut
     * @covers  Molajo\Cache\Adapter\File::chmodFile
     * @covers  Molajo\Cache\Adapter\File::createFolder
     * @covers  Molajo\Cache\Adapter\File::getFileContents
     *
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::__construct
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::connect
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::get
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::set
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::remove
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::clear
     *
     * @covers  Molajo\Cache\Driver::__construct
     * @covers  Molajo\Cache\Driver::get
     * @covers  Molajo\Cache\Driver::set
     * @covers  Molajo\Cache\Driver::remove
     * @covers  Molajo\Cache\Driver::clear
     *
     * @covers  Molajo\Cache\CacheItem::__construct
     * @covers  Molajo\Cache\CacheItem::getKey
     * @covers  Molajo\Cache\CacheItem::getValue
     * @covers  Molajo\Cache\CacheItem::setValue
     * @covers  Molajo\Cache\CacheItem::isHit
     *
     * @return  $this
     * @since   1.0
     */
    public function testGet()
    {
        $value = 'Stuff';
        $key   = serialize($value);

        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff';
        $key   = serialize($value);

        $results = $this->adapter->get($key);

        $this->assertEquals($value, $results->getValue());
    }

    /**
     * @covers  Molajo\Cache\Adapter\File::__construct
     * @covers  Molajo\Cache\Adapter\File::connect
     * @covers  Molajo\Cache\Adapter\File::get
     * @covers  Molajo\Cache\Adapter\File::set
     * @covers  Molajo\Cache\Adapter\File::remove
     * @covers  Molajo\Cache\Adapter\File::removeExpired
     * @covers  Molajo\Cache\Adapter\File::clear
     * @covers  Molajo\Cache\Adapter\File::close
     * @covers  Molajo\Cache\Adapter\File::filePut
     * @covers  Molajo\Cache\Adapter\File::chmodFile
     * @covers  Molajo\Cache\Adapter\File::createFolder
     * @covers  Molajo\Cache\Adapter\File::getFileContents
     *
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::__construct
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::connect
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::get
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::set
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::remove
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::clear
     *
     * @covers  Molajo\Cache\Driver::__construct
     * @covers  Molajo\Cache\Driver::get
     * @covers  Molajo\Cache\Driver::set
     * @covers  Molajo\Cache\Driver::remove
     * @covers  Molajo\Cache\Driver::clear
     *
     * @covers  Molajo\Cache\CacheItem::__construct
     * @covers  Molajo\Cache\CacheItem::getKey
     * @covers  Molajo\Cache\CacheItem::getValue
     * @covers  Molajo\Cache\CacheItem::setValue
     * @covers  Molajo\Cache\CacheItem::isHit
     *
     * @return  $this
     * @since   1.0
     */
    public function testSet()
    {
        $value = 'Stuff';
        $key   = serialize($value);

        $this->adapter->set($key, $value, $ttl = 0);

        $this->assertTrue(file_exists($this->options['cache_folder'] . '/' . $key));
    }

    /**
     * @covers  Molajo\Cache\Adapter\File::__construct
     * @covers  Molajo\Cache\Adapter\File::connect
     * @covers  Molajo\Cache\Adapter\File::get
     * @covers  Molajo\Cache\Adapter\File::set
     * @covers  Molajo\Cache\Adapter\File::remove
     * @covers  Molajo\Cache\Adapter\File::removeExpired
     * @covers  Molajo\Cache\Adapter\File::clear
     * @covers  Molajo\Cache\Adapter\File::close
     * @covers  Molajo\Cache\Adapter\File::filePut
     * @covers  Molajo\Cache\Adapter\File::chmodFile
     * @covers  Molajo\Cache\Adapter\File::createFolder
     * @covers  Molajo\Cache\Adapter\File::getFileContents
     *
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::__construct
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::connect
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::get
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::set
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::remove
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::clear
     *
     * @covers  Molajo\Cache\Driver::__construct
     * @covers  Molajo\Cache\Driver::get
     * @covers  Molajo\Cache\Driver::set
     * @covers  Molajo\Cache\Driver::remove
     * @covers  Molajo\Cache\Driver::clear
     *
     * @covers  Molajo\Cache\CacheItem::__construct
     * @covers  Molajo\Cache\CacheItem::getKey
     * @covers  Molajo\Cache\CacheItem::getValue
     * @covers  Molajo\Cache\CacheItem::setValue
     * @covers  Molajo\Cache\CacheItem::isHit
     *
     * @return  bool
     * @since   1.0
     */
    public function testRemove()
    {
        $value = 'Stuff';
        $key   = serialize($value);
        $this->adapter->remove($key);

        $this->assertFalse(file_exists($this->options['cache_folder'] . '/' . $key));
    }

    /**
     * @covers  Molajo\Cache\Adapter\File::__construct
     * @covers  Molajo\Cache\Adapter\File::connect
     * @covers  Molajo\Cache\Adapter\File::get
     * @covers  Molajo\Cache\Adapter\File::set
     * @covers  Molajo\Cache\Adapter\File::remove
     * @covers  Molajo\Cache\Adapter\File::removeExpired
     * @covers  Molajo\Cache\Adapter\File::clear
     * @covers  Molajo\Cache\Adapter\File::close
     * @covers  Molajo\Cache\Adapter\File::filePut
     * @covers  Molajo\Cache\Adapter\File::chmodFile
     * @covers  Molajo\Cache\Adapter\File::createFolder
     * @covers  Molajo\Cache\Adapter\File::getFileContents
     *
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::__construct
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::connect
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::get
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::set
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::remove
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::clear
     *
     * @covers  Molajo\Cache\Driver::__construct
     * @covers  Molajo\Cache\Driver::get
     * @covers  Molajo\Cache\Driver::set
     * @covers  Molajo\Cache\Driver::remove
     * @covers  Molajo\Cache\Driver::clear
     *
     * @covers  Molajo\Cache\CacheItem::__construct
     * @covers  Molajo\Cache\CacheItem::getKey
     * @covers  Molajo\Cache\CacheItem::getValue
     * @covers  Molajo\Cache\CacheItem::setValue
     * @covers  Molajo\Cache\CacheItem::isHit
     *
     * @return  bool
     * @since   1.0
     */
    public function testClear()
    {
        $keys = array();

        $value = 'Stuff1';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff2';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff3';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff4';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff5';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff6';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff7';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff8';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff9';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff10';
        $key   = serialize($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $this->adapter->clear();

        foreach ($keys as $key) {
            $this->assertFalse(file_exists($this->options['cache_folder'] . '/' . $key));
        }
    }

    /**
     * @covers  Molajo\Cache\Adapter\File::__construct
     * @covers  Molajo\Cache\Adapter\File::connect
     * @covers  Molajo\Cache\Adapter\File::get
     * @covers  Molajo\Cache\Adapter\File::set
     * @covers  Molajo\Cache\Adapter\File::remove
     * @covers  Molajo\Cache\Adapter\File::removeExpired
     * @covers  Molajo\Cache\Adapter\File::clear
     * @covers  Molajo\Cache\Adapter\File::close
     * @covers  Molajo\Cache\Adapter\File::filePut
     * @covers  Molajo\Cache\Adapter\File::chmodFile
     * @covers  Molajo\Cache\Adapter\File::createFolder
     * @covers  Molajo\Cache\Adapter\File::getFileContents
     *
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::__construct
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::connect
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::get
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::set
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::remove
     * @covers  Molajo\Cache\Adapter\AbstractAdapter::clear
     *
     * @covers  Molajo\Cache\Driver::__construct
     * @covers  Molajo\Cache\Driver::get
     * @covers  Molajo\Cache\Driver::set
     * @covers  Molajo\Cache\Driver::remove
     * @covers  Molajo\Cache\Driver::clear
     *
     * @covers  Molajo\Cache\CacheItem::__construct
     * @covers  Molajo\Cache\CacheItem::getKey
     * @covers  Molajo\Cache\CacheItem::getValue
     * @covers  Molajo\Cache\CacheItem::setValue
     * @covers  Molajo\Cache\CacheItem::isHit
     *
     * @return $this
     * @since   1.0
     */
    protected function tearDown()
    {
        foreach (new \DirectoryIterator($this->options['cache_folder']) as $file) {
            if ($file->isDot()) {
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($this->options['cache_folder']);
    }
}
