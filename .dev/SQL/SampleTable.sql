
CREATE TABLE `molajo_cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Content Table Primary Key',
  `key` varchar(255) NOT NULL DEFAULT ' ' COMMENT 'Cache Key',
  `value` text COMMENT 'Cached Value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
