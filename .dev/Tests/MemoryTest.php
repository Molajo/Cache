<?php
/**
 * Cache Test
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

use Molajo\Cache\Handler\Memory as MemoryCache;
use Molajo\Cache\Adapter;

/**
 * Cache Test
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
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
     * Setup testing
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $adapter_handler = new MemoryCache();

        $this->options                  = array();
        $this->options['cache_service'] = true;
        $this->options['cache_time']    = 600; //ten minutes
        $this->options['cache_handler'] = 'Memory';

        $this->adapter = new Adapter($adapter_handler, $this->options);

        return $this;
    }

    /**
     * Connect to the Cache
     *
     * @param   array $options
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
     * Create a cache entry
     *
     * @covers  Molajo\Cache\Handler\Memory::get
     *
     * @return  $this
     * @since   1.0
     */
    public function testGet()
    {
        $value = 'Stuff';
        $key   = md5($value);

        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff';
        $key   = md5($value);

        $results = $this->adapter->get($key);

        $this->assertEquals($value, $results->getValue());
    }

    /**
     * Create a cache entry
     *
     * @covers  Molajo\Cache\Handler\Memory::connect
     *
     * @return  $this
     * @since   1.0
     */
    public function testSet()
    {
        $value = 'Stuff';
        $key   = md5($value);

        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff';
        $key   = md5($value);

        $results = $this->adapter->get($key);

        $this->assertEquals($value, $results->getValue());
    }

    /**
     * Delete cache for specified $key value or expired cache
     *
     * @param   string $key
     *
     * @return  bool
     * @since   1.0
     */
    public function testRemove()
    {
        $value = 'Stuff';
        $key   = md5($value);
        $this->adapter->remove($key);

        $results = $this->adapter->get($key);

        $this->assertFalse($results->isHit());

    }

    /**
     * Clear all cache
     *
     * @return  bool
     * @since   1.0
     */
    public function testClear()
    {
        $keys = array();

        $value = 'Stuff1';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff2';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff3';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff4';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff5';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff6';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff7';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff8';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff9';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff10';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $this->adapter->clear();

        foreach ($keys as $key) {
            $results = $this->adapter->get($key);
            $this->assertFalse($results->isHit());
        }
    }

    /**
     * Get multiple CacheItems by Key
     *
     * @param   array $keys
     *
     * @return  array
     * @since   1.0
     */
    public function testGetMultiple()
    {
        $keys = array();

        $value = 'Stuff1';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff2';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff3';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff4';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff5';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff6';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff7';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff8';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff9';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff10';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $items = $this->adapter->getMultiple($keys);

        $this->assertEquals(2, count($items));
    }

    /**
     * Create a set of cache entries
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetMultiple()
    {
        $items = array();

        $value = 'dog';

        $items['stuff1'] = md5($value);
        $items['stuff2'] = md5($value);
        $items['stuff3'] = md5($value);
        $items['stuff4'] = md5($value);
        $items['stuff5'] = md5($value);
        $items['stuff6'] = md5($value);

        $this->adapter->setMultiple($items);

        $count = 0;
        foreach ($items as $key) {
            $results = $this->adapter->get($key);
            $this->assertEquals(md5('dog'), $results->getValue());
        }

        $this->assertEquals(6, $count);
    }

    /**
     * Remove a set of cache entries
     *
     * @param   array $keys
     *
     * @return  $this
     * @since   1.0
     */
    public function testRemoveMultiple()
    {
        $keys = array();

        $value = 'Stuff1';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $value = 'Stuff2';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff3';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff4';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff5';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff6';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff7';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff8';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff9';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);

        $value = 'Stuff10';
        $key   = md5($value);
        $this->adapter->set($key, $value, $ttl = 0);
        $keys[] = $key;

        $this->adapter->removeMultiple($keys);

        $results = $this->adapter->get(md5('dog'));
        $this->assertFalse($results->isHit());
    }

    /**
     * Tears Down
     *
     * @return $this
     * @since 1.0
     */
    protected function tearDown()
    {

    }
}
