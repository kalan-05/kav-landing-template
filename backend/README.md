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

## Helper scripts

Quick install:

```bash
bash scripts/install-template.sh
```

Beget deploy helper:

```bash
bash scripts/deploy-beget.sh
```

Before deploy ensure:

- `.env` is filled
- document root points to `backend/public`
- write permissions are available for `storage/` and `bootstrap/cache/`
- frontend production build is already copied to the public web root
