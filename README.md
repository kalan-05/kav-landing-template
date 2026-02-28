# KAV Landing Template

Универсальный шаблон лендинга на Laravel + Filament + Vue 3 + Vite.

## Что внутри

- `backend/` - Laravel API и Filament admin
- `frontend/` - витрина на Vue 3 + Vite
- админка по `/admin`
- публичный API для витрины
- блоковая структура контента
- команда, предложения, галерея, отзывы, контакты, SEO

## Для чего подходит

- корпоративные сайты
- экспертные сервисы
- продуктовые лендинги
- небольшие агентские и сервисные проекты
- нишевые сервисные проекты после замены demo-контента

## Профили запуска

Шаблон умеет стартовать с тремя профилями demo-контента:

- `service` - сервисный или экспертный лендинг
- `medical` - медицинский центр, клиника, кабинет, отделение
- `corporate` - корпоративный B2B-сайт или продуктовая компания

## Быстрый старт

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan template:install service --fresh --force
```

На Beget используйте `php8.2`.

Для медицинского или корпоративного профиля:

```bash
php artisan template:install medical --fresh --force
php artisan template:install corporate --fresh --force
```

Если нужен быстрый старт на Linux или Beget:

```bash
cd backend
TEMPLATE_PROFILE=medical bash scripts/install-template.sh
```

### Frontend

```bash
cd frontend
npm install
npm run build
```

После сборки публикуйте frontend build через ваш deploy-процесс в web root Laravel-проекта.

## Настройки темы

В `Админка -> Настройки сайта` шаблон позволяет менять:

- логотип сайта
- hero-изображение
- общую фотографию команды
- логотип разработчика
- фон страницы
- фон шапки
- фон карточек
- основные цвета текста
- цвет границ

Все эти значения приходят в `/api/settings` и применяются на фронтенде автоматически.

## Деплой на Beget

В репозитории есть готовый вспомогательный скрипт:

```bash
cd backend
bash scripts/deploy-beget.sh
```

Перед запуском проверьте:

- заполнен `.env`
- домен направлен на `backend/public`
- frontend build опубликован в web root Laravel
- `storage` и `bootstrap/cache` доступны на запись

## Что нужно заменить перед запуском клиента

- `.env` и домен
- favicon и логотип
- placeholder-изображения
- demo-контент в админке
- SEO и контакты
- подписи секций под конкретный бизнес

## Demo content

Проект включает стартовый demo-seed без клиентских данных и персональных фотографий.
Технические API-ключи `doctors` и `services` сохранены для совместимости, но в админке используются универсальные названия `Команда` и `Предложения`.
Переключение профиля доступно через `template:install` и `template:seed-demo`.
