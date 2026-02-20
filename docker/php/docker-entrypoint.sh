#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- php-fpm "$@"
fi

php /var/www/artisan key:generate >/dev/null 2>&1 || true #For dev/local only
php /var/www/artisan optimize >/dev/null 2>&1 || true
php /var/www/artisan migrate >/dev/null 2>&1 || true
php /var/www/artisan db:seed >/dev/null 2>&1 || true
php /var/www/vendor/bin/openapi ./app -o ./storage/app 2>&1 || true

exec docker-php-entrypoint "$@"
