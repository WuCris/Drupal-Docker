#!/bin/sh
set -e

SETTINGS_DIR=/opt/drupal/web/sites/default/
HASHSALT=$(drush eval "print_r(Drupal\Component\Utility\Crypt::randomBytesBase64(55))")

cp /etc/default/template/settings.local.php "$SETTINGS_DIR"
sed "s/HASHSALT/$HASHSALT/g" -i "$SETTINGS_DIR/settings.local.php"