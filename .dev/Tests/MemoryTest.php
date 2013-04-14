<?php
/**
 * Cache Test
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

defined('MOLAJO') or die;

use Molajo\Cache\Connection;

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
        $this->options = array();

        $this->options['cache_service'] = 1;
        $this->options['cache_time']    = 900;

        $this->adapter = new Connection('Memory', $this->options);

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
//        $this->assertTrue(file_exists($this->options['cache_folder']));

        return $this;
    }

    /**
     * Create a cache entry
     *
     * @covers Molajo\Cache\Handler\File::connect
     *
     * @return  $this
     * @since   1.0
     */
    public function testSet()
    {
        $value = 'Stuff';
        $key   = md5($value);

        $this->adapter->set($key, $value, $ttl = 0);

        $results = $this->adapter->get($key);

        $this->assertEquals($value, $results->getValue());
    }

    /**
     * Create a cache entry
     *
     * @covers Molajo\Cache\Handler\File::get
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

        $this->adapter->set($key, $value, $ttl = 0);
        $this->adapter->remove($key, $value, $ttl = 0);

        $afterDelete = $this->adapter->get($key);
        $this->assertFalse($afterDelete->isHit());
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

        foreach ($keys as $key) {
            $beforeClear = $this->adapter->get($key);
            $this->assertTrue($beforeClear->isHit());
        }

        $this->adapter->clear();

        foreach ($keys as $key) {
            $afterClear = $this->adapter->get($key);
            $this->assertFalse($afterClear->isHit());
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
     * @param   array         $items
     * @param   null|integer  $ttl
     *
     * @return  $this
     * @since   1.0
     */
    public function testSetMultiple($items = array(), $ttl = null)
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
        for($count = 1; $count < 7; $count++) {
            $afterClear = $this->adapter->get('stuff' . $count);
            $this->assertTrue($afterClear->isHit());
        }

        $this->assertEquals(7, $count);
    }

    /**
     * Remove a set of cache entries
     *
     * @param   array  $keys
     *
     * @return  $this
     * @since   1.0
     */
    public function testRemoveMultiple()
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
        for($count = 1; $count < 7; $count++) {
            $afterClear = $this->adapter->get('stuff' . $count);
            $this->assertTrue($afterClear->isHit());
        }

        $this->assertEquals(7, $count);

        $keys = array();
        $keys[] = 'stuff1';
        $keys[] = 'stuff2';
        $keys[] = 'stuff3';
        $this->adapter->removeMultiple($keys);

        $count = 0;
        for($count = 1; $count < 7; $count++) {
            if ($count < 4) {
                $afterRemoveMultiple = $this->adapter->get('stuff' . $count);
                $this->assertFalse($afterRemoveMultiple->isHit());
            } else {
                $afterRemoveMultiple = $this->adapter->get('stuff' . $count);
                $this->assertTrue($afterRemoveMultiple->isHit());
            }
        }

        $this->assertEquals(7, $count);
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
