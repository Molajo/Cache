<?php
/**
 * Cache Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

use Molajo\Cache\Adapter\Dummy as DummyCache;
use Molajo\Cache\Driver;

/**
 * Cache Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class DummyTest extends \PHPUnit_Framework_TestCase
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
     * @covers  Molajo\Cache\Adapter\Dummy::__construct
     * @covers  Molajo\Cache\Adapter\Dummy::connect
     * @covers  Molajo\Cache\Adapter\Dummy::get
     * @covers  Molajo\Cache\Adapter\Dummy::set
     * @covers  Molajo\Cache\Adapter\Dummy::remove
     * @covers  Molajo\Cache\Adapter\Dummy::clear
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->options                  = array();
        $this->options['cache_enabled'] = true;
        $this->options['cache_time']    = 600; //ten minutes

        $adapter_handler = new DummyCache($this->options);

        $this->adapter = new Driver($adapter_handler);

        return $this;
    }

    /**
     * @covers  Molajo\Cache\Adapter\Dummy::__construct
     * @covers  Molajo\Cache\Adapter\Dummy::connect
     * @covers  Molajo\Cache\Adapter\Dummy::get
     * @covers  Molajo\Cache\Adapter\Dummy::set
     * @covers  Molajo\Cache\Adapter\Dummy::remove
     * @covers  Molajo\Cache\Adapter\Dummy::clear
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
     * @covers  Molajo\Cache\Adapter\Dummy::__construct
     * @covers  Molajo\Cache\Adapter\Dummy::connect
     * @covers  Molajo\Cache\Adapter\Dummy::get
     * @covers  Molajo\Cache\Adapter\Dummy::set
     * @covers  Molajo\Cache\Adapter\Dummy::remove
     * @covers  Molajo\Cache\Adapter\Dummy::clear
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

        $this->assertTrue(is_object($results));
    }

    /**
     * @covers  Molajo\Cache\Adapter\Dummy::__construct
     * @covers  Molajo\Cache\Adapter\Dummy::connect
     * @covers  Molajo\Cache\Adapter\Dummy::get
     * @covers  Molajo\Cache\Adapter\Dummy::set
     * @covers  Molajo\Cache\Adapter\Dummy::remove
     * @covers  Molajo\Cache\Adapter\Dummy::clear
     *
     * @return  bool
     * @since   1.0
     */
    public function testRemove()
    {
        $value = 'Stuff';
        $key   = serialize($value);
        $this->adapter->remove($key);
        $result = $this->adapter->get($key);

        $this->assertTrue(is_object($result));
    }

    /**
     * @covers  Molajo\Cache\Adapter\Dummy::__construct
     * @covers  Molajo\Cache\Adapter\Dummy::connect
     * @covers  Molajo\Cache\Adapter\Dummy::get
     * @covers  Molajo\Cache\Adapter\Dummy::set
     * @covers  Molajo\Cache\Adapter\Dummy::remove
     * @covers  Molajo\Cache\Adapter\Dummy::clear
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
            $result = $this->adapter->get($key);
            $this->assertTrue(is_object($result));
        }
    }
}
