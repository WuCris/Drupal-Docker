ARG DRUPAL_VERSION
ARG DRUPAL_PHP_IMAGE

FROM ${DRUPAL_PHP_IMAGE}:${DRUPAL_VERSION}-php8.3-fpm-alpine3.19 as builder

FROM nginx:1.25-alpine

COPY etc/ /etc/nginx/
COPY docker-entrypoint.d/40-enable-cache.sh /docker-entrypoint.d/

RUN chmod 555 /docker-entrypoint.d/40-enable-cache.sh \
   && mkdir -p /opt/drupal/web

COPY --from=builder /opt/drupal/web /opt/drupal/web

ENV NGINX_ENTRYPOINT_LOCAL_RESOLVERS 1

# User ID must match in both PHP and Nginx containers for shared file access
RUN apk add shadow \
   && usermod -u 1001 nginx \
   && groupmod -g 1001 nginx

WORKDIR /opt/drupal/web
