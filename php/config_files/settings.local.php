<?php

$databases['default']['default'] = array (
  'database' => getenv('DATABASE'),
  'username' => getenv('DATABASE_USER'),
  'password' => getenv('DATABASE_PASSWORD'),
  'prefix' => '',
  'host' => getenv('DATABASE_HOST'),
  'port' => '3306',
  'isolation_level' => 'READ COMMITTED',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'driver' => 'mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);

$settings['hash_salt'] = 'HASHSALT';
