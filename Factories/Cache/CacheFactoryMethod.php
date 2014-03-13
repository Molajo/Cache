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
use CommonApi\IoC\FactoryMethodInterface;
use CommonApi\IoC\FactoryMethodBatchSchedulingInterface;
use Molajo\IoC\FactoryBase;

//todo: finish implementing DI logic for Cache options

/**
 * Cache Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class CacheFactoryMethod extends FactoryBase implements FactoryMethodInterface, FactoryMethodBatchSchedulingInterface
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
        $options['product_namespace']        = 'Molajo\\Cache\\Adapter';

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the FactoryMethodInterface
     * Retrieve a list of Interface dependencies and return the data ot the controller.
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        $options['base_path'] = $this->options['base_path'];

        $this->dependencies                = array();
        $this->dependencies['Dispatcher']  = $options;
        $this->dependencies['Runtimedata'] = $options;

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateClass()
    {
        $cache_handler = $this->dependencies['Runtimedata']->application->parameters->cache_handler;

        $method = 'get' . ucfirst(strtolower($cache_handler)) . 'Handler';
        if (method_exists($this, ucfirst(strtolower($method)))) {
            $handler = $this->$method();
        } else {
            $handler = $this->getFileHandler();
        }

        $this->product_result = $this->getAdapter($handler);

        return $this;
    }

    /**
     * Get the Apc Handler for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getApcHandler()
    {
    }

    /**
     * Get the Database Handler for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getDatabaseHandler()
    {
    }

    /**
     * Get the Dummy Handler for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getDummyHandler()
    {
    }

    /**
     * Get the File Handler for Cache
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getFileHandler()
    {
        $options                  = array();
        $options['cache_time']    = $this->dependencies['Runtimedata']->application->parameters->cache_time;
        $options['cache_folder']  = $this->dependencies['Runtimedata']->site->cache_folder;
        $options['cache_enabled'] = $this->dependencies['Runtimedata']->application->parameters->cache_enabled;
        $options['cache_enabled'] = 1;

        $class = 'Molajo\\Cache\\Handler\\File';

        try {
            return new $class($options);
        } catch (Exception $e) {

            throw new RuntimeException
            ('Cache: Could not instantiate Cache Adapter Handler: File');
        }
    }

    /**
     * Get the Memcached Handler for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getMemcachedHandler()
    {
    }

    /**
     * Get the Memory Handler for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getMemoryHandler()
    {
    }

    /**
     * Get the Redis Handler for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getRedisHandler()
    {
    }

    /**
     * Get the Wincache Handler for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getWincacheHandler()
    {
    }

    /**
     * Get the XCache Handler for Cache
     *
     * @param   object $application
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getXCacheHandler()
    {
    }

    /**
     * Get Cache Adapter, inject with specific Cache Adapter Handler
     *
     * @param   object $handler
     *
     * @return  object
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    protected function getAdapter($handler)
    {
        $class = $this->product_namespace;

        try {
            return new $class($handler);
        } catch (Exception $e) {

            throw new RuntimeException
            ('Cache: Could not instantiate Adapter for Cache');
        }
    }
}
