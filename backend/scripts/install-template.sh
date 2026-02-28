#!/usr/bin/env bash

set -euo pipefail

PHP_BIN="${PHP_BIN:-php}"
TEMPLATE_PROFILE="${TEMPLATE_PROFILE:-service}"

if [ ! -f ".env" ]; then
  cp .env.example .env
fi

composer install
"${PHP_BIN}" artisan template:install "${TEMPLATE_PROFILE}" --fresh --force

echo "Template backend installed with profile [${TEMPLATE_PROFILE}]."
