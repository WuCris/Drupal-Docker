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

$settings['hash_salt'] = 'YOr1oI06r1qckj8oVFxqXFBJ3HTweHCcC2Anmndqt0Dc4kk5v0BdvEBFX8MoWwuef6gAWoD0iQ';
