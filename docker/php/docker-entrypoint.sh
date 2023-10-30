#!/bin/sh
set -eu
# echo -e "${LARAVEL_ENV}" > /var/www/laravel/.env
echo "${LARAVEL_ENV}" > /var/www/laravel/.env
exec "$@"
