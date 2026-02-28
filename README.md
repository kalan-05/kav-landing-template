# KAV Landing Template

Шаблон медицинского лендинга на Laravel + Filament + Vue 3 + Vite.

## Что внутри

- `backend/` - Laravel API и Filament admin
- `frontend/` - витрина на Vue 3 + Vite
- админка по `/admin`
- публичный API для витрины
- блоковая структура контента
- врачи, услуги, галерея, отзывы, контакты, SEO

## Для чего подходит

- медицинские центры
- диагностические отделения
- частные клиники
- врачебные кабинеты и экспертные сервисы

## Быстрый старт

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

На Beget используйте `php8.2`.

Если нужен быстрый старт на Linux или Beget:

```bash
cd backend
bash scripts/install-template.sh
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

## Demo content

Проект включает стартовый demo-seed без клиентских данных и персональных фотографий.
