FROM nginx:alpine
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html
COPY . /var/www/html
HEALTHCHECK --interval=30s --timeout=5s --retries=3 CMD wget -qO- http://localhost/health >/dev/null || exit 1
