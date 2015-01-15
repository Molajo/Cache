<?php
/**
 * Cache Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

use Molajo\Cache\Adapter\Memory as MemoryCache;
use Molajo\Cache\Driver;

/**
 * Cache Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class MemoryTest extends \PHPUnit_Framework_TestCase
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
     * @covers  Molajo\Cache\Adapter\Memory::__construct
     * @covers  Molajo\Cache\Adapter\Memory::connect
     * @covers  Molajo\Cache\Adapter\Memory::get
     * @covers  Molajo\Cache\Adapter\Memory::createCacheItem
     * @covers  Molajo\Cache\Adapter\Memory::cacheItem
     * @covers  Molajo\Cache\Adapter\Memory::set
     * @covers  Molajo\Cache\Adapter\Memory::remove
     * @covers  Molajo\Cache\Adapter\Memory::clear
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
        $this->options['cache_time']    = 600; //ten minutes

        $adapter_handler = new MemoryCache($this->options);

        $this->adapter = new Driver($adapter_handler);

        return $this;
    }

    /**
     * @covers  Molajo\Cache\Adapter\Memory::__construct
     * @covers  Molajo\Cache\Adapter\Memory::connect
     * @covers  Molajo\Cache\Adapter\Memory::get
     * @covers  Molajo\Cache\Adapter\Memory::set
     * @covers  Molajo\Cache\Adapter\Memory::remove
     * @covers  Molajo\Cache\Adapter\Memory::clear
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
        $this->assertTrue(is_object($this->adapter));

        return $this;
    }

    /**
     * @covers  Molajo\Cache\Adapter\Memory::__construct
     * @covers  Molajo\Cache\Adapter\Memory::connect
     * @covers  Molajo\Cache\Adapter\Memory::get
     * @covers  Molajo\Cache\Adapter\Memory::set
     * @covers  Molajo\Cache\Adapter\Memory::remove
     * @covers  Molajo\Cache\Adapter\Memory::clear
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
     * @covers  Molajo\Cache\Adapter\Memory::__construct
     * @covers  Molajo\Cache\Adapter\Memory::connect
     * @covers  Molajo\Cache\Adapter\Memory::get
     * @covers  Molajo\Cache\Adapter\Memory::set
     * @covers  Molajo\Cache\Adapter\Memory::remove
     * @covers  Molajo\Cache\Adapter\Memory::clear
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

        $value = 'Stuff';
        $key   = serialize($value);

        $results = $this->adapter->get($key);

        $this->assertEquals($value, $results->getValue());
    }

    /**
     * @covers  Molajo\Cache\Adapter\Memory::__construct
     * @covers  Molajo\Cache\Adapter\Memory::connect
     * @covers  Molajo\Cache\Adapter\Memory::get
     * @covers  Molajo\Cache\Adapter\Memory::set
     * @covers  Molajo\Cache\Adapter\Memory::remove
     * @covers  Molajo\Cache\Adapter\Memory::clear
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

        $results = $this->adapter->get($key);

        $this->assertFalse($results->isHit());
    }

    /**
     * @covers  Molajo\Cache\Adapter\Memory::__construct
     * @covers  Molajo\Cache\Adapter\Memory::connect
     * @covers  Molajo\Cache\Adapter\Memory::get
     * @covers  Molajo\Cache\Adapter\Memory::set
     * @covers  Molajo\Cache\Adapter\Memory::remove
     * @covers  Molajo\Cache\Adapter\Memory::clear
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
            $results = $this->adapter->get($key);
            $this->assertFalse($results->isHit());
        }
    }
}
