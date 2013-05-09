<?php
/**
 * Cache Test
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Cache\Test;

use Molajo\Cache\Handler\Apc as ApcCache;
use Molajo\Cache\Adapter;

/**
 * Cache Test
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class ApcTest extends \PHPUnit_Framework_TestCase
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
        $adapter_handler = new ApcCache();

        $this->options                  = array();
        $this->options['cache_service'] = true;
        $this->options['cache_time']    = 600; //ten minutes

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
     * @covers  Molajo\Cache\Handler\File::get
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
     * Tears Down
     *
     * @return $this
     * @since 1.0
     */
    protected function tearDown()
    {

    }
}
