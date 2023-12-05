<?php

$databases['default']['default'] = array (
  'database' => 'drupal',
  'username' => 'drupal',
  'password' => 'drupalpassword',
  'prefix' => '',
  'host' => 'drupal-database',
  'port' => '3306',
  'isolation_level' => 'READ COMMITTED',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'driver' => 'mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);

$settings['hash_salt'] = 'HASHSALT';
