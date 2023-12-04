#!/bin/sh
set -e

SETTINGS_DIR=/opt/drupal/web/sites/default/

cp /etc/default/template/settings.local.php "$SETTINGS_DIR"

