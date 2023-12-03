FROM drupal:10.1.6-fpm-alpine

COPY entrypoint.sh /entrypoint.sh

RUN mkdir /docker-entrypoint.d \
  && chmod 775 -R /entrypoint.sh /docker-entrypoint.d

COPY config_files/ /opt/drupal/web/sites/default/

WORKDIR /opt/drupal/web