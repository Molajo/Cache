<?php
/**
 * Cache Test
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

/**
 * Cache Test
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class CacheFile2Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cache Object
     */
    protected $cache;

    /**
     * @var Cache Folder
     */
    protected $cache_folder;

    /**
     * Initialises Adapter
     */
    protected function setUp()
    {
        $class = 'Molajo\\Cache\\Adapter';

        $cache_service      = 1;
        $this->cache_folder = BASE_FOLDER . '/.dev/Data';
        $cache_time         = 9;
        $cache_type         = 'File';

        $this->cache = new $class($cache_service, $this->cache_folder, $cache_time, $cache_type);

        return;
    }

    /**
     * Return cached or parameter value
     *
     * @covers Molajo\Cache\Handler\File::get
     */
    public function testRemoveExpired()
    {
        $this->cache->removeExpired();
        $files = new \DirectoryIterator($this->cache_folder);
        $this->assertEquals(0, count($files));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }
}
