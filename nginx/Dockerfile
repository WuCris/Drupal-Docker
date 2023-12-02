FROM drupal:10.1.6-fpm-alpine as builder


FROM nginx:1.25-alpine

COPY etc/ /etc/nginx/
COPY docker-entrypoint.d/40-enable-cache.sh /docker-entrypoint.d/

RUN chmod 555 /docker-entrypoint.d/40-enable-cache.sh \
   && mkdir -p /opt/drupal/

COPY --from=builder /opt/drupal/ /opt/drupal/