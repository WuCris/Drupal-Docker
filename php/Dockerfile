FROM drupal:10.1.6-fpm-alpine

RUN composer require drush/drush \
  && apk add mariadb-client shadow

COPY docker-entrypoint.sh /
COPY docker-entrypoint.d/ /docker-entrypoint.d/

RUN chmod 775 -R /docker-entrypoint.sh /docker-entrypoint.d \
  && mkdir -p /etc/default/template

COPY config_files/settings.local.php /etc/default/template/
COPY config_files/settings.php /opt/drupal/web/sites/default/

RUN { \
		echo 'upload_max_filesize = 50M'; \
		echo 'post_max_size = 50M'; \
	} > /usr/local/etc/php/conf.d/upload-file-size.ini

# User ID must match in both PHP and Nginx containers for shared file access
RUN usermod -u 1001 www-data \
   && groupmod -g 1001 www-data

WORKDIR /opt/drupal/

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php-fpm"]