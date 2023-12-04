FROM drupal:10.1.6-fpm-alpine

COPY docker-entrypoint.sh /
COPY docker-entrypoint.d/ /docker-entrypoint.d/

RUN chmod 775 -R /docker-entrypoint.sh /docker-entrypoint.d \
  && mkdir -p /etc/default/template

COPY config_files/settings.local.php /etc/default/template/
COPY config_files/settings.php /opt/drupal/web/sites/default/

WORKDIR /opt/drupal/

RUN composer require drush/drush \
  && apk add mariadb-client

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php-fpm"]