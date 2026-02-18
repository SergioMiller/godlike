#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- php-fpm "$@"
fi

#php /var/www/artisan optimize >/dev/null 2>&1 || true

exec docker-php-entrypoint "$@"
