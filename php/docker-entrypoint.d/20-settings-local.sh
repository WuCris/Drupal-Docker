#!/bin/sh
set -e

SETTINGS_DIR=/opt/drupal/web/sites/default/
HASHSALT=$(pwgen -s 70)

SITE_URL=$(echo $URL | awk -F '.' '{print $(NF-1)}')
SITE_TLD=$(echo $URL | awk -F '.' '{print $(NF-0)}')

cp /etc/default/template/settings.local.php "$SETTINGS_DIR"

sed "s/HASHSALT/$HASHSALT/g" -i "$SETTINGS_DIR/settings.local.php"
sed "s/SITE_URL/$SITE_URL/g" -i "$SETTINGS_DIR/settings.local.php"
sed "s/SITE_TLD/$SITE_TLD/g" -i "$SETTINGS_DIR/settings.local.php"