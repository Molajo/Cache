<?php
/**
 * Memcached Handler Exception
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Cache\Exception;

use Exception;
use Molajo\Cache\Api\ExceptionInterface;

/**
 * Memcached Handler Exception
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
class MemcachedHandlerException extends Exception implements ExceptionInterface
{

}
