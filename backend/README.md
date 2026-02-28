# Backend

Laravel + Filament admin backend for the KAV medical landing template.

## Features

- Filament admin at `/admin`
- public read-only API for storefront
- review submission endpoint with captcha support
- editable page blocks, doctors, services, gallery, reviews and SEO

## Install

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

On Beget use `php8.2` for artisan commands.
