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
                'site_name' => 'Клиника экспертной диагностики',
                'phone_1' => '+7 900 000-00-00',
                'phone_2' => '+7 900 000-00-01',
                'email' => 'info@example.com',
                'address_main' => 'Санкт-Петербург, Невский проспект, 1',
                'worktime_main' => 'Ежедневно с 09:00 до 20:00',
                'social' => [
                    'tg' => '',
                    'wa' => '',
                    'vk' => '',
                ],
                'seo_title' => 'Клиника экспертной диагностики',
                'seo_description' => 'Шаблон медицинского сайта на Laravel, Filament и Vue 3.',
                'seo_keywords' => 'медицинский центр, диагностика, узи, консультации',
                'map_lat' => 59.9386,
                'map_lng' => 30.3141,
                'map_zoom' => 16,
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
                    'booking_label' => 'Записаться',
                    'booking_url' => 'https://example.com/booking',
                    'department_url' => 'https://example.com/about',
                    'logo_title' => 'Клиника экспертной диагностики',
                    'logo_lines' => "КЛИНИКА\nЭКСПЕРТНОЙ\nДИАГНОСТИКИ",
                    'logo_alt' => 'Логотип клиники',
                ],
            ],
            [
                'key' => 'hero',
                'title' => 'Комплексная диагностика',
                'content' => 'и консультации специалистов',
                'is_enabled' => true,
                'sort_order' => 10,
                'meta' => ['section_id' => 'hero'],
            ],
            [
                'key' => 'about',
                'title' => 'О нас',
                'content' => 'Современный медицинский центр с удобной записью, сильной командой и прозрачной коммуникацией.',
                'is_enabled' => true,
                'sort_order' => 20,
                'meta' => [
                    'section_id' => 'about',
                    'content_alignment' => 'left',
                    'block1_title' => 'Почему выбирают нас',
                    'block1_items' => "Экспертная диагностика\nСовременное оборудование\nУдобная запись без лишних шагов",
                    'block1_history_title' => 'Подход к работе',
                    'block1_history_text' => 'Шаблон подходит для клиник, диагностических центров и частных кабинетов.',
                    'history_text' => "Все ключевые тексты и списки редактируются через админку.\nСтруктура подходит под медицинский лендинг с акцентом на доверие и SEO.",
                    'block2_title' => 'Что можно показать в этом блоке',
                    'block2_group1_title' => 'Для пациента',
                    'block2_group1_items' => "Преимущества центра\nНаправления работы\nФорматы консультаций",
                    'block2_group2_title' => 'Для SEO и доверия',
                    'block2_group2_items' => "Опыт команды\nОписание оборудования\nПодтверждение экспертности",
                    'block3_lead' => 'Секция легко адаптируется под структуру конкретной клиники.',
                    'block3_diagnosis' => 'Можно рассказать о диагностике, профилактике, консультациях и маршруте пациента.',
                    'block3_text' => 'Тексты разбиты на управляемые поля, чтобы не приходилось менять код ради каждого абзаца.',
                    'block4_title' => 'Что входит в шаблон',
                    'block4_items' => "Laravel backend\nFilament admin\nVue storefront\nОтзывы с модерацией\nSEO-базис и адаптив",
                    'final_text' => "Шаблон можно использовать как базу для нового проекта.\nПосле запуска замените demo-контент на реальные данные клиента.",
                ],
            ],
            [
                'key' => 'services',
                'title' => 'Диагностика',
                'content' => 'Основные направления центра. Список редактируется в отдельной сущности и отображается без пересборки витрины.',
                'is_enabled' => true,
                'sort_order' => 30,
                'meta' => [
                    'section_id' => 'services',
                    'content_alignment' => 'left',
                ],
            ],
            [
                'key' => 'doctors',
                'title' => 'Врачи',
                'content' => 'Команда специалистов, которые ведут прием, диагностику и сопровождение пациента.',
                'is_enabled' => true,
                'sort_order' => 40,
                'meta' => [
                    'section_id' => 'pricing',
                    'subtitle' => 'НАША КОМАНДА',
                    'team_count_label' => 'Команда специалистов',
                    'team_image_alt' => 'Команда клиники',
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
                    'doctor_prefix' => 'Врач:',
                    'prev_label' => '← Назад',
                    'next_label' => 'Вперед →',
                    'prev_aria_label' => 'Предыдущие отзывы',
                    'next_aria_label' => 'Следующие отзывы',
                    'form_title' => 'Добавить отзыв',
                    'name_label' => 'Ваше имя:',
                    'name_placeholder' => 'Введите ваше имя',
                    'doctor_label' => 'Выберите врача:',
                    'doctor_placeholder' => '-- Выберите врача --',
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
                            'text' => 'Понравилась четкая организация и внимательное отношение к пациенту.',
                        ],
                        [
                            'author_name' => 'Игорь',
                            'doctor_name' => 'Иван Петров',
                            'rating' => 5,
                            'text' => 'Удобная запись, понятные рекомендации и аккуратная работа администратора.',
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
                    'map_aria_label' => 'Карта проезда клиники',
                    'fallback_text' => 'Не удалось загрузить интерактивную карту.',
                    'fallback_link_text' => 'Открыть место на Яндекс.Картах',
                ],
            ],
            [
                'key' => 'footer',
                'title' => 'Клиника экспертной диагностики',
                'content' => 'Диагностика, консультации и профилактика для частных клиник и медицинских центров.',
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
            ['full_name' => 'Анна Смирнова', 'position' => 'Врач ультразвуковой диагностики', 'regalia' => 'к.м.н.'],
            ['full_name' => 'Иван Петров', 'position' => 'Кардиолог', 'regalia' => null],
            ['full_name' => 'Мария Волкова', 'position' => 'Врач функциональной диагностики', 'regalia' => null],
            ['full_name' => 'Ольга Соколова', 'position' => 'Терапевт', 'regalia' => null],
        ];

        $doctorIdsByName = [];

        foreach ($doctors as $index => $doctorData) {
            $doctor = Doctor::query()->updateOrCreate(
                ['full_name' => $doctorData['full_name']],
                [
                    ...$doctorData,
                    'description' => 'Demo-профиль врача. Замените текст, должность и фотографию через админку.',
                    'photo' => null,
                    'sort_order' => ($index + 1) * 10,
                    'is_active' => true,
                ]
            );

            $doctorIdsByName[$doctor->full_name] = $doctor->id;
        }

        $services = [
            ['title' => 'Первичный прием', 'group' => 'Консультации'],
            ['title' => 'Повторный прием', 'group' => 'Консультации'],
            ['title' => 'УЗИ органов брюшной полости', 'group' => 'УЗИ'],
            ['title' => 'ЭКГ', 'group' => 'Функциональная диагностика'],
            ['title' => 'Суточное мониторирование ЭКГ', 'group' => 'Функциональная диагностика'],
            ['title' => 'Check-up программы', 'group' => 'Комплексные услуги'],
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
                'text' => 'Понравилась четкая организация и внимательное отношение к пациенту.',
                'doctor_id' => $doctorIdsByName['Анна Смирнова'] ?? null,
            ],
            [
                'author_name' => 'Игорь',
                'rating' => 5,
                'text' => 'Удобная запись, понятные рекомендации и аккуратная работа администратора.',
                'doctor_id' => $doctorIdsByName['Иван Петров'] ?? null,
            ],
            [
                'author_name' => 'Марина',
                'rating' => 4,
                'text' => 'Хороший demo-отзыв для стартового наполнения шаблона.',
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
