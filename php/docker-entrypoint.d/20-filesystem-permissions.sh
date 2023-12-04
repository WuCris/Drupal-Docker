#!/bin/sh

set -e

FILES_PATH=/opt/drupal/web/sites/default/files

chown -R www-data:www-data "$FILES_PATH"
chmod -R 660  "$FILES_PATH"
chmod -R ug+X "$FILES_PATH"