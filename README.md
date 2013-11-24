
=======
Molajo Cache API
=======

[![Build Status](https://travis-ci.org/Molajo/Cache.png?branch=master)](https://travis-ci.org/Molajo/Cache)

Simple, clean cache API for PHP applications to
[get](https://github.com/Molajo/Cache/tree/master/Cache#get),
[set] (https://github.com/Molajo/Cache/tree/master/Cache#set),
[remove] (https://github.com/Molajo/Cache/tree/master/Cache#remove),
[getMultiple] (https://github.com/Molajo/Cache/tree/master/Cache#getmultiple),
[setMultiple] (https://github.com/Molajo/Cache/tree/master/Cache#setmultiple),
[removeMultiple] (https://github.com/Molajo/Cache/tree/master/Cache#removemultiple),
and
[clear] (https://github.com/Molajo/Cache/tree/master/Cache#clear),
cache is the manner. Cache Handlers available include:
[Apc](https://github.com/Molajo/Cache/tree/master/Cache#apc),
[Database](https://github.com/Molajo/Cache/tree/master/Cache#database),
[Dummy](https://github.com/Molajo/Cache/tree/master/Cache#dummy),
[File](https://github.com/Molajo/Cache/tree/master/Cache#file),
[Memcached](https://github.com/Molajo/Cache/tree/master/Cache#memcached),
[Memory](https://github.com/Molajo/Cache/tree/master/Cache#memory),
[Redis](https://github.com/Molajo/Cache/tree/master/Cache#redis),
[Wincache](https://github.com/Molajo/Cache/tree/master/Cache#wincache), and
[xCache](https://github.com/Molajo/Cache/tree/master/Cache#xcache).

## At a glance ...

1. Instantiate a Cache Handler.
2. Instantiate the Adapter, injecting it with the Handler.
3. Set cache.
4. Get cache.
5. Remove cache.
6. Clear cache.

```php

    // 1. Instantiate a Cache Handler.
    $options = array();
    $options['cache_folder']  = SITE_BASE_PATH . '/' . $application->get('system_cache_folder', 'cache');
    $options['cache_time']    = $application->get('system_cache_time', 900);
    $options['cache_handler'] = $application->get('cache_handler', 'File');

    use Molajo\Cache\Adapter\File as FileCache;
    $adapter_handler = new FileCache($options);

    // 2. Instantiate the Adapter, injecting it with the Handler.
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

    // 3. Set cache.
    $adapter->set('key value', 'cache this value for seconds =>', 86400);

    // 4. Get Cache.
    $cacheItem = $adapter->get('this is the key for a cache item');

    if ($cacheItem->isHit() === false) {
        // deal with no cache
    } else {
        echo $cacheItem->value; // Use the Cached Value
    }

    // 5. Remove cache.
    $adapter->remove('key value');

    // 6. Clear cache.
    $adapter->clear();

```

## Cache API

Common API for Cache operations:
[get](https://github.com/Molajo/Cache/tree/master/Cache#get),
[set] (https://github.com/Molajo/Cache/tree/master/Cache#set),
[remove] (https://github.com/Molajo/Cache/tree/master/Cache#remove),
[getMultiple] (https://github.com/Molajo/Cache/tree/master/Cache#getmultiple),
[setMultiple] (https://github.com/Molajo/Cache/tree/master/Cache#setmultiple),
[removeMultiple] (https://github.com/Molajo/Cache/tree/master/Cache#removemultiple),
and
[clear] (https://github.com/Molajo/Cache/tree/master/Cache#clear) methods.

### Get
Retrieves a CacheItem object associated with the key. If the value is not found, an exception is
thrown.

```php
    try {
        $cacheItem = $adapter->get($key);

    } catch (Exception $e) {
        // deal with the exception
    }

    if ($cacheItem->isHit() === true) {
        $cached_value = $cacheItem->getValue();
    } else {
        // cache is not available - do what you have to do.
    }
```


**Parameters**
- **$key** contains the key value for the requested cache

### Set
Stores a value as cache for the specified Key value and number of seconds specified.

```php
    try {
        $adapter->set($key, $value, $ttl);

    } catch (Exception $e) {
        // deal with the exception
    }

```

**Parameters**
- **$key** contains the value to use for the cache key
- **$value** contains the value to be stored as cache
- **$ttl** "Time to live" which is the number of seconds the cache is considered relevant

### Remove
Removes a cache entry associated with the specified Key value.

```php
    try {
        $adapter->remove($key);

    } catch (Exception $e) {
        // deal with the exception
    }

```

**Parameters**
- **$key** contains the value to use for the cache key

### Clear
Remove all cache for this Cache Handler instance.

```php
    try {
        $adapter->clear();

    } catch (Exception $e) {
        // deal with the exception
    }

```

**Parameters**
- **n/a** no parameters are required


### getMultiple
Retrieve an array of CacheItem objects for the specified key values.

```php
    try {
        $adapter->getMultiple($keys);

    } catch (Exception $e) {
        // deal with the exception
    }

```

**Parameters**
- **$keys** an array of key values to use when retrieving CacheItems, returning the set of objects as an array


### setMultiple
Uses the associative array of items to store multiple items in cache for specified keys, given the time specified.

```php
    try {
        $adapter->setMultiple($items, $ttl);

    } catch (Exception $e) {
        // deal with the exception
    }

```

**Parameters**
- **$items** an associative array of key, value pairs for which cache items must be created
- **$ttl** "Time to live" which is the number of seconds the cache is considered relevant


### removeMultiple
Uses the array of key values to delete multiple items currently stored in cache for specified keys.

```php
    try {
        $adapter->setMultiple($items, $ttl);

    } catch (Exception $e) {
        // deal with the exception
    }

```

**Parameters**
- **$items** an associative array of key, value pairs for which cache items must be created
- **$ttl** "Time to live" which is the number of seconds the cache is considered relevant


## Cache Adapter Handlers

Cache Handlers available include:
[Apc](https://github.com/Molajo/Cache/tree/master/Cache#apc),
[Database](https://github.com/Molajo/Cache/tree/master/Cache#database),
[Dummy](https://github.com/Molajo/Cache/tree/master/Cache#dummy),
[File](https://github.com/Molajo/Cache/tree/master/Cache#file),
[Memcached](https://github.com/Molajo/Cache/tree/master/Cache#memcached),
[Memory](https://github.com/Molajo/Cache/tree/master/Cache#memory),
[Redis](https://github.com/Molajo/Cache/tree/master/Cache#redis),
[Wincache](https://github.com/Molajo/Cache/tree/master/Cache#wincache), and
[xCache](https://github.com/Molajo/Cache/tree/master/Cache#xcache).

### Apc
APC (Alternative PHP Cache) comes standard with PHP. An APC Cache Handler is available
with *Molajo Cache* and can be used, as follows.

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\Apc;
    $adapter_handler = new Apc($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### Database
Before using the *Database Cache Handler*, a table must be available with four columns:
id (identity column), key (varchar(255)), value (text) and expiration (integer). When instantiating
the Cache Handler, pass in the database connection, the name of the database table for cache,
the value for the RDBMS quote and name quote, as shown in this example.

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Specific to the Database Handler
    $options['database_connection'] = $connection;
    $options['database_table']      = 'xyz_cache_table';
    $options['database_quote']      = "'";
    $options['database_namequote']  = '`';

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\Database;
    $adapter_handler = new Database($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### Dummy
The *Dummy Cache Handler* can be used for testing purpose. It does not really cache data.
Use, as follows:

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\Dummy as DummyCache;
    $adapter_handler = new DummyCache($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### File
The *File Cache Handler* can be used to turn the local filesystem into a caching device.
Use, as follows:

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Specific to the File Handler
    $options['cache_handler']       = '/Absolute/Path/To/Cache/Folder';

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\File as FileCache;
    $adapter_handler = new FileCache($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### Memcached
The *Memcached Cache Handler* requires the `memcached` PHP extension be loaded and that the `Memcached`
 class exists. For more information, see [Memcached in the PHP Manual](http://us1.php.net/manual/en/book.memcached.php).
Use, as follows:

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Specific to the Memcached Handler
    $options['memcached_pool']         = $connection;
    $options['memcached_compression']  = 'xyz_cache_table';
    $options['memcached_servers']      = "'";

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\Memcached
    $adapter_handler = new Memcached($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### Memory

The *Memory Cache Handler* can be used storing the variables in memory. This can be used with Sessions
to create persistence, if desired. Use, as follows:

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\Memory
    $adapter_handler = new Memory($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### Redis

The *Redis Cache Handler* can be used storing the variables in memory. This can be used with Sessions
to create persistence, if desired. Use, as follows:

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\Redis
    $adapter_handler = new Redis($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### Wincache

The *Wincache Cache Handler* requires the PHP extension `wincache` is loaded and that `wincache_ucache_get` is callable.
For more information, see [Windows Cache for PHP.](http://us1.php.net/manual/en/book.wincache.php). Besides
using the Windows Operating System, there are no other configuration options required to use `Wincache`.

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\Wincache
    $adapter_handler = new Wincache($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

### xCache

The *xCache Handler* requires the PHP extension `xcache` is loaded and that `xcache_get` is callable.

```php
    $options = array();

    // Standard Cache Options
    $options['cache_service']       = 1;
    $options['cache_time']          = 86400;

    // Instantiate Cache Handler
    use Molajo\Cache\Adapter\XCache
    $adapter_handler = new XCache($options);

    // Instantiate Cache Adapter, injecting the Handler
    use Molajo\Cache\Adapter;
    $adapter = new Adapter($adapter_handler);

```

## Install using Composer from Packagist

### Step 1: Install composer in your project

```php
    curl -s https://getcomposer.org/installer | php
```

### Step 2: Create a **composer.json** file in your project root

```php
{
    "require": {
        "Molajo/Cache": "1.*"
    }
}
```

### Step 3: Install via composer

```php
    php composer.phar install
```

## Requirements and Compliance
 * PHP framework independent, no dependencies
 * Requires PHP 5.3, or above
 * [Semantic Versioning](http://semver.org/)
 * Compliant with:
    * [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) and [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) Namespacing
    * [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) Coding Standards
    * [PSR-Cache Interfaces](https://github.com/php-fig/fig-standards/pull/96) (Still in Draft)
 * [phpDocumentor2] (https://github.com/phpDocumentor/phpDocumentor2)
 * [phpUnit Testing] (https://github.com/sebastianbergmann/phpunit)
 * Author [AmyStephen](http://twitter.com/AmyStephen)
 * [Travis Continuous Improvement] (https://travis-ci.org/profile/Molajo)
 * Listed on [Packagist] (http://packagist.org) and installed using [Composer] (http://getcomposer.org/)
 * Use github to submit [pull requests](https://github.com/Molajo/Cache/pulls) and [features](https://github.com/Molajo/Cache/issues)
 * Licensed under the MIT License - see the `LICENSE` file for details
