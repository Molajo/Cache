<?php
/**
 * Cache Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Cache;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

//todo: finish implementing DI logic for Cache options

/**
 * Cache Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class CacheFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Constructor
     *
     * @param  array $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['product_name']             = basename(__DIR__);
        $options['store_instance_indicator'] = true;
        $options['product_namespace']        = 'Molajo\\Cache\\Driver';

        parent::__construct($options);
    }

    /**
     * Instantiate a new adapter and inject it into the Driver for the FactoryInterface
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        $options['base_path'] = $this->options['base_path'];

        $this->dependencies                = array();
        $this->dependencies['Runtimedata'] = $options;

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $cache_adapter = $this->dependencies['Runtimedata']->application->parameters->cache_handler;

        $method = 'get' . ucfirst(strtolower($cache_adapter)) . 'Adapter';
        if (method_exists($this, ucfirst(strtolower($method)))) {
            $adapter = $this->$method();
        } else {
            $adapter = $this->getFileAdapter();
        }

        $this->product_result = $this->getDriver($adapter);

        return $this;
    }

    /**
     * Get the Apc Adapter for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getApcAdapter()
    {
    }

    /**
     * Get the Database Adapter for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getDatabaseAdapter()
    {
    }

    /**
     * Get the Dummy Adapter for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getDummyAdapter()
    {
    }

    /**
     * Get the File Adapter for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getFileAdapter()
    {
        $options                  = array();
        $options['cache_time']    = $this->dependencies['Runtimedata']->application->parameters->cache_time;
        $options['cache_folder']  = $this->dependencies['Runtimedata']->site->cache_folder;
//        $options['cache_enabled'] = $this->dependencies['Runtimedata']->application->parameters->cache_service;
        $options['cache_enabled'] = 1;

        $class = 'Molajo\\Cache\\Adapter\\File';

        try {
            return new $class($options);
        } catch (Exception $e) {

            throw new RuntimeException
            ('Cache: Could not instantiate Cache Adapter Adapter: File');
        }
    }

    /**
     * Get the Memcached Adapter for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getMemcachedAdapter()
    {
    }

    /**
     * Get the Memory Adapter for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getMemoryAdapter()
    {
    }

    /**
     * Get the Redis Adapter for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getRedisAdapter()
    {
    }

    /**
     * Get the Wincache Adapter for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getWincacheAdapter()
    {
    }

    /**
     * Get the XCache Adapter for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getXCacheAdapter()
    {
    }

    /**
     * Get Cache Adapter, inject with specific Cache Adapter Adapter
     *
     * @param   object $adapter
     *
     * @return  object
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function getDriver($adapter)
    {
        $class = $this->product_namespace;

        try {
            return new $class($adapter);

        } catch (Exception $e) {

            //throw new RuntimeException
            //('Cache: Could not instantiate Adapter for Cache');
            echo 'Cache: Could not instantiate Adapter for Cache';
            die;
        }
    }
}
