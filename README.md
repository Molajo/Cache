**NOT COMPLETE**

=======
Cache
=======

[![Build Status](https://travis-ci.org/Molajo/Cache.png?branch=master)](https://travis-ci.org/Molajo/Cache)

Simple, uniform File and Directory Services API for PHP applications enabling interaction with multiple Cache types
(ex., Local, Ftp, Github, LDAP, etc.).

## System Requirements ##

* PHP 5.3.3, or above
* [PSR-0 compliant Autoloader](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
* PHP Framework independent
* [optional] PHPUnit 3.5+ to execute the test suite (phpunit --version)

## What is Cache? ##

**Cache** provides a common API to read, list, write, rename, delete, copy or move files and folders
on (and between) filesystems using adapters. In addition, the API enables applications to perform system
administrative tasks like changing the owner, group, file dates, and file and folder permissions. Benefits
include a simple, uniform API, ability to copy and move files between filesystems, and an interface
to fileservices for application support services, like Cache, Logging, Message, and Cache.

## Basic Usage ##

Each **Cache** command shares the same syntax and the same four parameters:

### Cache Request ###

```php
    $adapter = new Molajo/Cache/Adapter($action, $path, $filesystem_type, $options);
```
#### Parameters ####

- **$action** valid values: Read, List, Write, Delete, Rename, Copy, Move, GetRelativePath, Chmod, Touch, Metadata;
- **$path** contains an absolute path from the filesystem root to be used to fulfill the action requested;
- **$filesystem_type** Identifier for the file system. Examples include Local (default), Ftp, Virtual, Dropbox, etc.;
- **$options** Associative array of named pair values needed for the specific Action (examples below).

#### Results ####

The output from the filesystem action request, along with relevant metadata, can be accessed from the returned
object, as follows:

**Action Results:** For any request where data is to be returned, this example shows how to retrieve the output:

```php
    echo $adapter->fs->data;
```

**Metadata** including the file or folder (name), parent, extension, etc., is accessed in this manner:

```php
    echo $adapter->fs->size;
    echo $adapter->fs->mime_type;
    echo $adapter->fs->parent;
    echo 'etc';
```
**Metadata about the Fileystem** filesystem_type, root, persistence, default_directory_permissions,
default_file_permissions, read_only.

**Metadata about requested path** (be it a file or folder) path, is_absolute, absolute_path, exists, owner,
group, create_date, access_date, modified_date, is_readable, is_writable, is_executable, is_directory,
is_file, is_link, type, name, parent, extension, no_extension, size, and mime_type.

Metadata is defined in the [Molajo\Cache\Properties](https://github.com/Molajo/Cache/blob/master/src/Molajo/Cache/Type/CacheType.php) class. The Properties
class can be extended and customized, as needed, by Cache.

### Cache Commands ###

#### Read ####

To read a specific file from a filesystem:

```php
    $adapter = new \Molajo\Cache\Adapter('Read', 'location/of/file.txt');
    echo $adapter->fs->data;
```

#### List

To list all files and folders for a given path, limiting the results to those files which
have the extension types identified:

```php
    $options = array(
        'extension'    => 'txt,doc,ppt'
    );

    $adapter = new \Molajo\Cache\Adapter('List', 'directory-name', $options);
    $results = $adapter->fs->data);
```

#### Write

To write the information in **$data** to the **Log** filesystem using the **standard** log.

```php
    $options = array(
        'data'    => 'Here are the words to write to the file.',
    );
    $adapter      = new \Molajo\Cache\Adapter('Write', 'standard', $options, 'Log');
```

#### Copy

To copy file(s) and folder(s) from a filesystem to a location on the same or a different filesystem.

This example shows how to backup a local file to a remote location.

```php
    $options = array(
        'target_directory'       => 'name/of/target/folder',
        'target_name'            => 'single-file-copy.txt',
        'replace'                => false,
        'target_filesystem_type' => 'Cloud'
    );
    $adapter = new \Molajo\Cache\Adapter('Copy', 'name/of/source/file', $options);
```

#### Move

The only difference between the copy and the move is that the files copied are removed from the
source location after the operation is complete.

This example shows how to move files from a local directory to an archive location on the local filesystem.

```php
    $options = array(
        'target_directory'       => '/archive/year2012',
        'replace'                => false
    );

    $adapter = new \Molajo\Cache\Adapter('Move', 'current/folder/year2012', $options);
```

#### Delete

As with the list, copy, and move, the delete can be used for individual files and it can be used
to specify a folder and all dependent subfolders and files should be deleted.

```php
    $adapter = new \Molajo\Cache\Adapter('Delete', 'name/of/source/folder');
```

### Special Purpose File Operations

### Merged Caches

```php
    $adapter = new \Molajo\Cache\Adapter('List', '/first/location');
    $data1   = $adapter->fs->data;

    $adapter = new \Molajo\Cache\Adapter('List', '/second/location');
    $data2   = $adapter->fs->data;

    $merged  = array_merge($data1, $data2);
```
#### Backup

This shows how to backup a file on one filesystem to another filesystem.

```php
    $options = array(
        'source_adapter' => 'local',
        'source_path'    => '/x/y/example',
        'target_adapter' => 'ftp',
        'target_path'    => '/x/y/backup',
        'archive'        => 'zip'
    );

    $adapter = new \Molajo\Cache\File($options);
    $data    = $adapter->backup ();
```

#### Download

This shows how to backup a file on one filesystem to another filesystem.

```php
    $options = array(
        'source_adapter' => 'local',
        'source_path'    => '/x/y/example',
        'target_adapter' => 'ftp',
        'target_path'    => '/x/y/backup',
        'archive'        => 'zip'
    );

    $adapter = new \Molajo\Cache\File($options);
    $data    = $adapter->backup ();
```

#### Ftp Server

This shows how to backup a file on one filesystem to another filesystem.

```php
    $options = array(
        'source_adapter' => 'local',
        'source_path'    => '/x/y/example',
        'target_adapter' => 'ftp',
        'target_path'    => '/x/y/backup',
        'archive'        => 'zip'
    );

    $adapter = new \Molajo\Cache\File($options);
    $data    = $adapter->backup ();
```

### Installation

#### Install using Composer from Packagist

**Step 1** Install composer in your project:

```php
    curl -s https://getcomposer.org/installer | php
```

**Step 2** Create a **composer.json** file in your project root:

```php
{
    "require": {
        "Molajo/Cache": "1.*"
    }
}
```

**Step 3** Install via composer:

```php
    php composer.phar install
```

**Step 4** Add this line to your application’s **index.php** file:

```php
    require 'vendor/autoload.php';
```

This instructs PHP to use Composer’s autoloader for **Cache** project dependencies.

#### Or, Install Manually

Download and extract **Cache**.

Copy the Molajo folder (first subfolder of src) into your Vendor directory.

Register Molajo\Cache\ subfolder in your autoload process.

About
=====

Molajo Project adopted the following:

 * [Semantic Versioning](http://semver.org/)
 * [PSR-0 Autoloader Interoperability](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
 * [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
 and [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
 * [phpDocumentor2] (https://github.com/phpDocumentor/phpDocumentor2)
 * [phpUnit Testing] (https://github.com/sebastianbergmann/phpunit)
 * [Travis Continuous Improvement] (https://travis-ci.org/profile/Molajo)
 * [Packagist] (https://packagist.org)


Submitting pull requests and features
------------------------------------

Pull requests [GitHub](https://github.com/Molajo/Fileservices/pulls)

Features [GitHub](https://github.com/Molajo/Fileservices/issues)

Author
------

Amy Stephen - <AmyStephen@gmail.com> - <http://twitter.com/AmyStephen><br />
See also the list of [contributors](https://github.com/Molajo/Fileservices/contributors) participating in this project.

License
-------

**Molajo Cache** is licensed under the MIT License - see the `LICENSE` file for details

Acknowledgements
----------------

**W3C File API: Directories and System** [W3C Working Draft 17 April 2012 → ](http://www.w3.org/TR/file-system-api/)
specifications were followed, as closely as possible.

More Information
----------------
- [Usage](/Cache/doc/usage.md)
- [Extend](/Cache/doc/extend.md)
- [Specifications](/Cache/doc/specifications.md)
