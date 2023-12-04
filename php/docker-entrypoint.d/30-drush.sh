#!/bin/sh

set -e 

# Fixes error where initial drush install malfunctions 
# due to site files needing to be mounted
composer -d /opt/drupal require drush/drush
