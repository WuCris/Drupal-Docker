FROM drupal:10.1.6-fpm-alpine

COPY docker-entrypoint.sh /
COPY docker-entrypoint.d/ /docker-entrypoint.d/

RUN chmod 775 -R /docker-entrypoint.sh /docker-entrypoint.d

WORKDIR /opt/drupal/

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php-fpm"]