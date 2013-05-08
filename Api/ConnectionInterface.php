<?php
/**
 * Cache Connection Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache\Api;

use Molajo\Cache\Exception\AdapterException;

/**
 * Cache Connection Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @since     1.0
 * @api
 */
interface ConnectionInterface
{
    /**
     * Connect to the Cache
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0
     * @throws  AdapterException
     */
    public function connect($options = array());

    /**
     * Close the Connection
     *
     * @return  $this
     * @since   1.0
     * @throws  AdapterException
     */
    public function close();
}
