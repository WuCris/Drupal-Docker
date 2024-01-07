FROM drupal:10.1.6-fpm-alpine

RUN apk add mariadb-client shadow pwgen

RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl clear-cache \
        && apk del .build-dependencies

COPY docker-entrypoint.sh /
COPY docker-entrypoint.d/ /docker-entrypoint.d/

RUN chmod 775 -R /docker-entrypoint.sh /docker-entrypoint.d \
  && mkdir -p /etc/default/template \
  && mkdir /opt/drupal/web/sites/default/files

COPY config_files/settings.local.php /etc/default/template/
COPY config_files/settings.php /opt/drupal/web/sites/default/

RUN { \
		echo 'upload_max_filesize = 50M'; \
		echo 'post_max_size = 50M'; \
	} > /usr/local/etc/php/conf.d/upload-file-size.ini

# User ID must match in both PHP and Nginx containers for shared file access
RUN usermod -u 1001 www-data \
   && groupmod -g 1001 www-data

RUN chown -R www-data:www-data /opt/drupal \
  && chmod 550 /opt/drupal \
  && chmod ug+X /opt/drupal

WORKDIR /opt/drupal/
USER www-data
RUN composer require drush/drush

# Install plugins and themes example
#RUN composer require 'drupal/zuvi:^10.2'

USER root
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php-fpm"]