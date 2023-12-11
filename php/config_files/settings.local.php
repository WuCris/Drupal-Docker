<?php

$databases['default']['default'] = array (
  'database' => getenv('MARIADB_DATABASE'),
  'username' => getenv('MARIADB_USER'),
  'password' => getenv('MARIADB_PASSWORD'),
  'prefix' => '',
  'host' => getenv('DATABASE_MASTER'),
  'port' => '3306',
  'isolation_level' => 'READ COMMITTED',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'driver' => 'mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);

$databases['default']['replica'] = array (
  'database' => getenv('MARIADB_DATABASE'),
  'username' => getenv('MARIADB_USER'),
  'password' => getenv('MARIADB_PASSWORD'),
  'prefix' => '',
  'host' => getenv('DATABASE_SLAVE'),
  'port' => '3306',
  'isolation_level' => 'READ COMMITTED',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'driver' => 'mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);

$settings['hash_salt'] = 'HASHSALT';

$settings['trusted_host_patterns'] = [
  '^www\.SITE_URL\.SITE_TLD$',
  '^SITE_URL\.SITE_TLD$',
  '^localhost$'
];