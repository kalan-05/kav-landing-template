<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\PageBlock;
use App\Models\Review;
use App\Models\Service;
use App\Models\SiteSetting;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class InitialContentSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Экспертный проект',
                'phone_1' => '+7 900 000-00-00',
                'phone_2' => '+7 900 000-00-01',
                'email' => 'info@example.com',
                'address_main' => 'Санкт-Петербург, Невский проспект, 1',
                'worktime_main' => 'Пн-Пт с 10:00 до 19:00',
                'social' => [
                    'tg' => '',
                    'wa' => '',
                    'vk' => '',
                ],
                'logo' => null,
                'hero_image' => null,
                'team_image' => null,
                'developer_logo' => null,
                'seo_title' => 'Экспертный проект',
                'seo_description' => 'Универсальный шаблон сайта на Laravel, Filament и Vue 3.',
                'seo_keywords' => 'шаблон сайта, laravel, filament, vue, корпоративный лендинг',
                'map_lat' => 59.9386,
                'map_lng' => 30.3141,
                'map_zoom' => 16,
                'theme_body_bg' => '#F2F6FA',
                'theme_nav_bg' => '#edf0f0',
                'theme_accent_bg' => '#fefeff',
                'theme_text_body' => '#494949',
                'theme_text_secondary' => '#7a7777',
                'theme_text_accent' => '#DAC5A7',
                'theme_border_color' => '#6c5d48',
            ]
        );

        $pageBlocks = [
            [
                'key' => 'header',
                'title' => 'Шапка сайта',
                'content' => '',
                'is_enabled' => true,
                'sort_order' => 5,
                'meta' => [
                    'section_id' => 'header',
                    'booking_label' => 'Связаться',
                    'booking_url' => 'https://example.com/contact',
                    'department_url' => 'https://example.com/about',
                    'logo_title' => 'Экспертный проект',
                    'logo_lines' => "ЭКСПЕРТНЫЙ\nПРОЕКТ",
                    'logo_alt' => 'Логотип проекта',
                ],
            ],
            [
                'key' => 'hero',
                'title' => 'Современный сервис',
                'content' => 'с управляемым контентом',
                'is_enabled' => true,
                'sort_order' => 10,
                'meta' => ['section_id' => 'hero'],
            ],
            [
                'key' => 'about',
                'title' => 'О проекте',
                'content' => 'Гибкий шаблон для запуска корпоративного, сервисного или экспертного лендинга.',
                'is_enabled' => true,
                'sort_order' => 20,
                'meta' => [
                    'section_id' => 'about',
                    'content_alignment' => 'left',
                    'block1_title' => 'Почему это удобно',
                    'block1_items' => "Управляемый контент\nБыстрый запуск\nЧистая структура проекта",
                    'block1_history_title' => 'Как использовать шаблон',
                    'block1_history_text' => 'Этот starter подходит для корпоративных сайтов, экспертных сервисов и продуктовых лендингов.',
                    'history_text' => "Все ключевые тексты и списки редактируются через админку.\nСтруктура помогает быстро запускать новые сайты без ручной правки кода под каждый блок.",
                    'block2_title' => 'Что можно показать в этом блоке',
                    'block2_group1_title' => 'Для клиента',
                    'block2_group1_items' => "Преимущества\nНаправления работы\nФорматы сотрудничества",
                    'block2_group2_title' => 'Для доверия и SEO',
                    'block2_group2_items' => "Опыт команды\nКейсы\nПрозрачный процесс запуска",
                    'block3_lead' => 'Секция легко адаптируется под структуру конкретного проекта.',
                    'block3_diagnosis' => 'Можно рассказать о продукте, услугах, кейсах, процессах и точках контакта.',
                    'block3_text' => 'Тексты разбиты на управляемые поля, чтобы не приходилось менять код ради каждого абзаца.',
                    'block4_title' => 'Что входит в шаблон',
                    'block4_items' => "Laravel backend\nFilament admin\nVue storefront\nОтзывы с модерацией\nSEO-базис и адаптив",
                    'final_text' => "Шаблон можно использовать как основу для нового проекта.\nПосле запуска замените demo-контент на реальные данные клиента.",
                ],
            ],
            [
                'key' => 'services',
                'title' => 'Предложения',
                'content' => 'Основные предложения, форматы работы или элементы каталога. Список редактируется отдельно и отображается без пересборки витрины.',
                'is_enabled' => true,
                'sort_order' => 30,
                'meta' => [
                    'section_id' => 'services',
                    'content_alignment' => 'left',
                ],
            ],
            [
                'key' => 'doctors',
                'title' => 'Команда',
                'content' => 'Люди, которые формируют продукт, поддерживают клиентов и отвечают за результат.',
                'is_enabled' => true,
                'sort_order' => 40,
                'meta' => [
                    'section_id' => 'pricing',
                    'subtitle' => 'КЛЮЧЕВЫЕ УЧАСТНИКИ',
                    'team_count_label' => 'Команда проекта',
                    'team_image_alt' => 'Команда проекта',
                    'content_alignment' => 'center',
                    'subtitle_alignment' => 'center',
                    'team_heading_alignment' => 'center',
                ],
            ],
            [
                'key' => 'gallery',
                'title' => 'Галерея',
                'content' => '',
                'is_enabled' => true,
                'sort_order' => 50,
                'meta' => [
                    'section_id' => 'gallery',
                    'prev_label' => '← Назад',
                    'next_label' => 'Вперед →',
                ],
            ],
            [
                'key' => 'reviews',
                'title' => 'Отзывы',
                'content' => '',
                'is_enabled' => true,
                'sort_order' => 60,
                'meta' => [
                    'section_id' => 'reviews',
                    'doctor_prefix' => 'Участник:',
                    'prev_label' => '← Назад',
                    'next_label' => 'Вперед →',
                    'prev_aria_label' => 'Предыдущие отзывы',
                    'next_aria_label' => 'Следующие отзывы',
                    'form_title' => 'Добавить отзыв',
                    'name_label' => 'Ваше имя:',
                    'name_placeholder' => 'Введите ваше имя',
                    'doctor_label' => 'Выберите участника:',
                    'doctor_placeholder' => '-- Выберите участника --',
                    'rating_label' => 'Оценка (1-5):',
                    'rating_placeholder' => 'Оцените от 1 до 5',
                    'review_text_label' => 'Текст отзыва:',
                    'review_text_placeholder' => 'Напишите ваш отзыв',
                    'submit_label' => 'Оставить отзыв',
                    'submitting_label' => 'Отправка...',
                    'success_message' => 'Спасибо! Отзыв принят на модерацию.',
                    'error_message' => 'Ошибка при отправке отзыва',
                    'network_error_message' => 'Не удалось отправить отзыв.',
                    'spam_message' => 'Обнаружена спам-активность.',
                    'captcha_missing_message' => 'Капча не настроена. Сообщите администратору сайта.',
                    'captcha_required_message' => 'Подтвердите, что вы не робот.',
                    'anonymous_label' => 'Аноним',
                    'initial_reviews' => json_encode([
                        [
                            'author_name' => 'Елена',
                            'doctor_name' => 'Анна Смирнова',
                            'rating' => 5,
                            'text' => 'Понравилась четкая организация, понятная коммуникация и быстрый старт проекта.',
                        ],
                        [
                            'author_name' => 'Игорь',
                            'doctor_name' => 'Иван Петров',
                            'rating' => 5,
                            'text' => 'Удобная структура, прозрачный процесс и аккуратная реализация без лишних шагов.',
                        ],
                    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ],
            ],
            [
                'key' => 'contact',
                'title' => 'Контакты',
                'content' => '',
                'is_enabled' => true,
                'sort_order' => 70,
                'meta' => [
                    'section_id' => 'contact',
                ],
            ],
            [
                'key' => 'map',
                'title' => 'Как нас найти',
                'content' => 'Санкт-Петербург',
                'is_enabled' => true,
                'sort_order' => 80,
                'meta' => [
                    'section_id' => 'map-section',
                    'menu_label' => 'Карта',
                    'map_aria_label' => 'Карта проезда',
                    'fallback_text' => 'Не удалось загрузить интерактивную карту.',
                    'fallback_link_text' => 'Открыть адрес на карте',
                ],
            ],
            [
                'key' => 'footer',
                'title' => 'Экспертный проект',
                'content' => 'Сервис, кейсы и контактная информация для нового клиента.',
                'is_enabled' => true,
                'sort_order' => 90,
                'meta' => [
                    'section_id' => 'footer',
                    'developer_label' => 'Разработчик',
                    'developer_url' => 'https://kavweb.ru',
                    'developer_aria_label' => 'Перейти на сайт разработчика',
                    'copyright' => '© 2026. Все права защищены.',
                ],
            ],
        ];

        foreach ($pageBlocks as $block) {
            PageBlock::query()->updateOrCreate(['key' => $block['key']], $block);
        }

        $doctors = [
            ['full_name' => 'Анна Смирнова', 'position' => 'Руководитель проекта', 'regalia' => 'Стратегия'],
            ['full_name' => 'Иван Петров', 'position' => 'Продуктовый эксперт', 'regalia' => 'Запуск'],
            ['full_name' => 'Мария Волкова', 'position' => 'Менеджер по работе с клиентами', 'regalia' => 'Коммуникация'],
            ['full_name' => 'Ольга Соколова', 'position' => 'Аналитик', 'regalia' => 'Исследования'],
        ];

        $doctorIdsByName = [];

        foreach ($doctors as $index => $doctorData) {
            $doctor = Doctor::query()->updateOrCreate(
                ['full_name' => $doctorData['full_name']],
                [
                    ...$doctorData,
                    'description' => 'Demo-профиль участника. Замените имя, роль, описание и фотографию через админку.',
                    'photo' => null,
                    'sort_order' => ($index + 1) * 10,
                    'is_active' => true,
                ]
            );

            $doctorIdsByName[$doctor->full_name] = $doctor->id;
        }

        $services = [
            ['title' => 'Стратегическая сессия', 'group' => 'Консультации'],
            ['title' => 'Аудит проекта', 'group' => 'Консультации'],
            ['title' => 'Запуск лендинга', 'group' => 'Запуск'],
            ['title' => 'Контент-поддержка', 'group' => 'Поддержка'],
            ['title' => 'SEO-базис', 'group' => 'Поддержка'],
            ['title' => 'Интеграция форм и заявок', 'group' => 'Технические работы'],
        ];

        foreach ($services as $index => $serviceData) {
            Service::query()->updateOrCreate(
                ['title' => $serviceData['title']],
                [
                    ...$serviceData,
                    'sort_order' => ($index + 1) * 10,
                    'is_active' => true,
                ]
            );
        }

        $reviews = [
            [
                'author_name' => 'Елена',
                'rating' => 5,
                'text' => 'Понравилась четкая организация, понятная коммуникация и быстрый запуск.',
                'doctor_id' => $doctorIdsByName['Анна Смирнова'] ?? null,
            ],
            [
                'author_name' => 'Игорь',
                'rating' => 5,
                'text' => 'Удобная структура, прозрачный процесс и аккуратная реализация.',
                'doctor_id' => $doctorIdsByName['Иван Петров'] ?? null,
            ],
            [
                'author_name' => 'Марина',
                'rating' => 4,
                'text' => 'Хороший demo-отзыв для стартового наполнения универсального шаблона.',
                'doctor_id' => $doctorIdsByName['Мария Волкова'] ?? null,
            ],
        ];

        foreach ($reviews as $index => $reviewData) {
            Review::query()->updateOrCreate(
                ['author_name' => $reviewData['author_name'], 'text' => $reviewData['text']],
                [
                    ...$reviewData,
                    'source' => 'manual',
                    'status' => 'published',
                    'published_at' => CarbonImmutable::now()->subDays(3 - $index),
                    'author_contacts' => null,
                ]
            );
        }
    }
}