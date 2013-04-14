
=======
Molajo Cache API
=======

[![Build Status](https://travis-ci.org/Molajo/Cache.png?branch=master)](https://travis-ci.org/Molajo/Cache)

Simple, clean cache API for PHP applications to
[get](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#get),
[set] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#set),
[remove] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#remove),
[getMultiple] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#getmultiple),
[setMultiple] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#setmultiple),
[removeMultiple] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#removemultiple),
and
[clear] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#clear),
cache is the manner. Cache Handlers available include:
[Apc](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#apc),
[Database](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#database),
[Dummy](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#dummy),
[File](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#file),
[Memcached](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#memcached),
[Memory](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#memory),
[Redis](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#redis),
[Wincache](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#wincache), and
[xCache](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#xcache).

## At a glance ... ##
First, the application connects to a Cache Handler.
Then, the application can use that connection to perform cache operations.

### Example ###
```php

    // Connect to Cache Handler
    use Molajo\Cache\Connection;
    $adapter = new Connection('Memory');

    // Use connection for cache operations
    $cacheItem = $adapter->get('this is the key for a cache item');
    if ($cacheItem->isHit() === false) {
        // deal with no cache
    } else {
        echo $cacheItem->value; // Cached Value requested by Key
    }

    $adapter->set('key value', 'cache this value for seconds =>', 1440);

    $adapter->remove('key value');

    $adapter->clear();

```

### Requirements and Compliance ###
 * PHP framework independent, no dependencies
 * Requires PHP 5.3, or above
 * [Semantic Versioning](http://semver.org/)
 * Compliant with:
    * [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) and [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) Namespacing
    * [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) Coding Standards
    * [PSR-Cache Interfaces](https://github.com/php-fig/fig-standards/pull/96) (Still in Draft)
 * [phpDocumentor2] (https://github.com/phpDocumentor/phpDocumentor2)
 * [phpUnit Testing] (https://github.com/sebastianbergmann/phpunit)
 * [Travis Continuous Improvement] (https://travis-ci.org/profile/Molajo)
 * Listed on [Packagist] (http://packagist.org) and installed using [Composer] (http://getcomposer.org/)
 * Use github to submit [pull requests](https://github.com/Molajo/Cache/pulls) and [features](https://github.com/Molajo/Cache/issues)

## Cache API ##

Common API for Cache operations:
[get](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#get),
[set] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#set),
[remove] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#remove),
[getMultiple] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#getmultiple),
[setMultiple] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#setmultiple),
[removeMultiple] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#removemultiple),
and
[clear] (https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#clear) methods.

### Get ###
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

### Set ###
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

### Remove ###
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

### Clear ###
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


### getMultiple ###
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


### setMultiple ###
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


### removeMultiple ###
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


## Cache Adapter Handlers ##

Cache Handlers available include:
[Apc](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#apc),
[Database](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#database),
[Dummy](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#dummy),
[File](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#file),
[Memcached](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#memcached),
[Memory](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#memory),
[Redis](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#redis),
[Wincache](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#wincache), and
[xCache](https://github.com/Molajo/Standard/tree/master/Vendor/Molajo/Cache#xcache).

### Apc ###
APC (Alternative PHP Cache) comes standard with PHP. An APC Cache Handler is available
with *Molajo Cache* and can be used, as follows.

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        $this->handler = new Connection('Apc', $this->options);

        // Use the cache handler normally for cache operations

```

### Database ###
Before using the *Database Cache Handler*, a table must be available with four columns:
id (identity column), key (varchar(255)), value (text) and expiration (integer). When instantiating
the Cache Handler, pass in the database connection, the name of the database table for cache,
the value for the RDBMS quote and name quote, as shown in this example.

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        // Specific to the Database Handler
        $this->options['database_connection'] = $connection;
        $this->options['database_table']      = 'xyz_cache_table';
        $this->options['database_quote']      = "'";
        $this->options['database_namequote']  = '`';

        $this->handler = new Connection('Database', $this->options);

        // Use the cache handler normally for cache operations

```

### Dummy ###
The *Dummy Cache Handler* can be used for testing purpose. It does not really cache data.
Use, as follows:

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        $this->handler = new Connection('Dummy', $this->options);

        // Use the cache handler normally for cache operations

```

### File ###
The *File Cache Handler* can be used to turn the local filesystem into a caching device.
Use, as follows:

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        // Specific to the File Handler
        $this->options['cache_handler']       = '/Absolute/Path/To/Cache/Folder;

        $this->handler = new Connection('File', $this->options);

        // Use the cache handler normally for cache operations

```
### Memcached ###
The *Memcached Cache Handler* requires the `memcached` PHP extension be loaded and that the `Memcached`
 class exists. For more information, see [Memcached in the PHP Manual](http://us1.php.net/manual/en/book.memcached.php).
Use, as follows:

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        // Specific to the Memcached Handler
        $this->options['memcached_pool']         = $connection;
        $this->options['memcached_compression']  = 'xyz_cache_table';
        $this->options['memcached_servers']      = "'";

        $this->handler = new Connection('File', $this->options);

        // Use the cache handler normally for cache operations

```

### Memory ###
The *Memory Cache Handler* can be used storing the variables in memory. This can be used with Sessions
to create persistence, if desired. Use, as follows:

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        $this->handler = new Connection('Memory', $this->options);

        // Use the cache handler normally for cache operations

```

### Redis ###

The *Redis Cache Handler* can be used storing the variables in memory. This can be used with Sessions
to create persistence, if desired. Use, as follows:

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        $this->handler = new Connection('Memory', $this->options);

        // Use the cache handler normally for cache operations

```

### Wincache ###
The *Wincache Cache Handler* requires the PHP extension `wincache` is loaded and that `wincache_ucache_get` is callable.
For more information, see [Windows Cache for PHP.](http://us1.php.net/manual/en/book.wincache.php). Besides
using the Windows Operating System, there are no other configuration options required to use `Wincache`.

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        $this->handler = new Connection('Memory', $this->options);

        // Use the cache handler normally for cache operations

```

### xCache ###

The *xCache Handler* requires the PHP extension `xcache` is loaded and that `xcache_get` is callable.
For more information, see [Windows Cache for PHP.](http://us1.php.net/manual/en/book.wincache.php). Besides
using the Windows Operating System, there are no other configuration options required to use `Wincache`.

```php
        $this->options = array();

        // Standard Cache Options
        $this->options['cache_service']       = 1;
        $this->options['cache_time']          = 1440;

        $this->handler = new Connection('Memory', $this->options);

        // Use the cache handler normally for cache operations

```

## Install using Composer from Packagist ##

### Step 1: Install composer in your project ###

```php
    curl -s https://getcomposer.org/installer | php
```

### Step 2: Create a **composer.json** file in your project root ###

```php
{
    "require": {
        "Molajo/Cache": "1.*"
    }
}
```

### Step 3: Install via composer ###

```php
    php composer.phar install
```

Author
------

Amy Stephen - <AmyStephen@gmail.com> - <http://twitter.com/AmyStephen><br />
See also the list of [contributors](https://github.com/Molajo/Cache/contributors) participating in this project.

License
-------

**Molajo Cache** is licensed under the MIT License - see the `LICENSE` file for details
