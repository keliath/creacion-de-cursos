# syntax=docker/dockerfile:1

# Base build stage: install PHP extensions
FROM php:8.1-fpm-alpine AS base

RUN set -eux; \
    apk add --no-cache tzdata bash \
    && docker-php-ext-install mysqli \
    && rm -rf /var/cache/apk/*

# Configure PHP
COPY docker/php/conf.d/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Create app directory and set perms
WORKDIR /var/www/html
RUN addgroup -S app && adduser -S app -G app \
    && chown -R app:app /var/www/html

# ---------- Development image (bind mount code) ----------
FROM base AS dev
USER app
CMD ["php-fpm"]

# ---------- Production image (code baked in) ----------
FROM base AS prod
COPY --chown=app:app . /var/www/html
USER app
HEALTHCHECK --interval=30s --timeout=5s --retries=3 CMD php -v >/dev/null || exit 1
CMD ["php-fpm"]
