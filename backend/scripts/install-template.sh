#!/usr/bin/env bash

set -euo pipefail

PHP_BIN="${PHP_BIN:-php}"

if [ ! -f ".env" ]; then
  cp .env.example .env
fi

composer install
"${PHP_BIN}" artisan key:generate --force
"${PHP_BIN}" artisan migrate --seed --force
"${PHP_BIN}" artisan storage:link || true
"${PHP_BIN}" artisan optimize:clear

echo "Template backend installed."
