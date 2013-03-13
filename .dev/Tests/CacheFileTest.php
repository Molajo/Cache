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

/**
 * Cache Test
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class CacheTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Cache Object
     */
    protected $cache;


    /**
     * @var Cache Object
     */
    protected $cache_folder;

    /**
     * Initialises Adapter
     */
    protected function setUp()
    {
        $class = 'Molajo\\Cache\\Adapter';

        $cache_service = 1;
        $this->cache_folder = BASE_FOLDER . '/.dev/Data';
        $cache_time = 9;
        $cache_type = 'File';

        $this->cache = new $class($cache_service, $this->cache_folder, $cache_time, $cache_type);

        return;
    }

    /**
     * Create a cache entry or set a parameter value
     *
     * @covers Molajo\Cache\Type\FileCache::set
     */
    public function testSet()
    {
        $value = 'Stuff';
        $key = md5($value);

        $this->cache->set($key, $value, $ttl = null);

        $this->assertTrue(file_exists($this->cache_folder . '/' . $key));
    }

    /**
     * Create a cache entry or set a parameter value
     *
     * @covers Molajo\Cache\Type\FileCache::get
     */
    public function testGet()
    {
        $value = 'Stuff';
        $key = md5($value);

        $this->cache->set($key, $value, $ttl = null);

        $value = 'Stuff';
        $key = md5($value);

        $results = $this->cache->get($key);

        $this->assertEquals($value, $results);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        foreach (new \DirectoryIterator($this->cache_folder) as $file) {
            if ($file->isDot()) {
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($this->cache_folder);
    }
}
