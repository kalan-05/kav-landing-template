#!/usr/bin/env bash

set -euo pipefail

PHP_BIN="${PHP_BIN:-php8.2}"

composer install --no-dev --optimize-autoloader
"${PHP_BIN}" artisan migrate --force
"${PHP_BIN}" artisan storage:link || true
"${PHP_BIN}" artisan optimize:clear
"${PHP_BIN}" artisan config:cache
"${PHP_BIN}" artisan view:cache

echo "Deploy helper finished. Use route:cache only if routes do not contain closures."
