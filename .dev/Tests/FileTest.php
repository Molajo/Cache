<?php
/**
 * Cache Test
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

use Molajo\Cache\Handler\File as FileCache;
use Molajo\Cache\Adapter;

/**
 * Cache Test
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
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
     * Setup testing
     *
     * @return  $this
     * @since   1.0
     */
    protected function setUp()
    {
        $this->options                  = array();
        $this->options['cache_service'] = true;
        $this->options['cache_folder']  = __DIR__ . '/Cache';
        $this->options['cache_time']    = 600; //ten minutes
        $this->options['cache_handler'] = 'File';

        $adapter_handler = new FileCache($this->options);

        $this->adapter = new Adapter($adapter_handler);

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
        $this->assertTrue(file_exists($this->options['cache_folder']));

        return $this;
    }

    /**
     * Create a cache entry
     *
     * @covers  Molajo\Cache\Handler\File::get
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
     * Create a cache entry
     *
     * @covers  Molajo\Cache\Handler\File::connect
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
        $key   = serialize($value);
        $this->adapter->remove($key);

        $this->assertFalse(file_exists($this->options['cache_folder'] . '/' . $key));
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
     * Tears Down
     *
     * @return $this
     * @since 1.0
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
