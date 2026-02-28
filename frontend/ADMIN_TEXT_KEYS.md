# Редактирование текста через админку (KAV Landing Template)

Витрина читает текст из `PageBlocks` и `SiteSettings`.

## 1) Основные блоки (`Сайт -> Блоки страницы`)
- `hero`
  - `title` -> верхняя строка первого экрана
  - `content` -> главный заголовок
- `about`
  - `title` -> заголовок секции
  - `content` -> вводный абзац
  - остальные тексты секции `О проекте` -> через `meta`
- `services`
  - `title`, `content`
  - список элементов берется из `Сайт -> Предложения`
- `doctors`
  - `title`, `content`
  - карточки команды берутся из `Сайт -> Команда`
- `gallery`
  - кнопки слайдера меняются через `meta`
  - изображения берутся из `Сайт -> Галерея`
- `reviews`
  - заголовок и подписи формы идут через `meta`
  - опубликованные отзывы берутся из API `/api/reviews`
- `contact`
  - `title`
  - контакты берутся из `Сайт -> Настройки сайта`
- `map`
  - `title` -> заголовок над картой
  - `content` или `meta.subtitle` -> подпись под картой
- `header`
  - служебный блок шапки
- `footer`
  - служебный блок footer

## 2) Meta-ключи

### `about` meta
- `block1_title`
- `block1_items`
- `block1_history_title`
- `block1_history_text`
- `history_text`
- `block2_title`
- `block2_group1_title`
- `block2_group1_items`
- `block2_group2_title`
- `block2_group2_items`
- `block3_lead`
- `block3_diagnosis`
- `block3_text`
- `block4_title`
- `block4_items`
- `final_text`

### `doctors` meta
Технический ключ секции сохранен для совместимости, но в админке это блок `Команда`.
- `subtitle`
- `team_count_label`
- `team_image_alt`
- `content_alignment`
- `subtitle_alignment`
- `team_heading_alignment`

### `gallery` meta
- `prev_label`
- `next_label`

### `reviews` meta
- `doctor_prefix`
- `prev_label`
- `next_label`
- `prev_aria_label`
- `next_aria_label`
- `form_title`
- `name_label`
- `name_placeholder`
- `doctor_label`
- `doctor_placeholder`
- `rating_label`
- `rating_placeholder`
- `review_text_label`
- `review_text_placeholder`
- `submit_label`
- `submitting_label`
- `success_message`
- `error_message`
- `network_error_message`
- `spam_message`
- `captcha_missing_message`
- `captcha_required_message`
- `anonymous_label`
- `initial_reviews`

### `map` meta
- `subtitle`
- `map_aria_label`
- `fallback_text`
- `fallback_link_text`
- `menu_label`

### `header` meta
- `booking_label`
- `booking_url`
- `department_url`
- `logo_title`
- `logo_lines`
- `logo_alt`

### `footer` meta
- `developer_label`
- `developer_url`
- `developer_aria_label`
- `copyright`

## 3) Важно
- Названия пунктов меню в шапке и footer берутся из `title` блоков `about/services/doctors/reviews/contact`.
- Телефон, email, адрес, график, SEO, координаты карты и theme settings редактируются в `Настройки сайта`.
- Технические ключи `doctors` и `services` оставлены в API и коде для совместимости шаблона.