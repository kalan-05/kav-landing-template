<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\MediaUrl;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    private const DEFAULT_THEME = [
        'body_bg_color' => '#F2F6FA',
        'nav_bg_color' => '#edf0f0',
        'accent_bg_color' => 'rgba(254, 254, 255, 0.83)',
        'text_body_color' => '#494949',
        'text_secondary_color' => '#7a7777',
        'text_accent_color' => '#DAC5A7',
        'border_color' => '#6c5d48',
    ];

    public function index(): JsonResponse
    {
        $settings = SiteSetting::query()->first();

        if (! $settings) {
            return response()->json([
                'site_name' => null,
                'phones' => [],
                'email' => null,
                'address_main' => null,
                'worktime_main' => null,
                'social' => [],
                'media' => [
                    'logo_url' => null,
                    'hero_image_url' => null,
                    'team_image_url' => null,
                    'developer_logo_url' => null,
                ],
                'seo' => [
                    'title' => null,
                    'description' => null,
                    'keywords' => null,
                ],
                'map' => [
                    'lat' => null,
                    'lng' => null,
                    'zoom' => 14,
                ],
                'theme' => self::DEFAULT_THEME,
                'og_image_url' => null,
            ]);
        }

        $phones = array_values(array_filter([
            $settings->phone_1,
            $settings->phone_2,
        ], static fn (?string $phone): bool => filled($phone)));

        return response()->json([
            'site_name' => $settings->site_name,
            'phones' => $phones,
            'email' => $settings->email,
            'address_main' => $settings->address_main,
            'worktime_main' => $settings->worktime_main,
            'social' => $settings->social ?? [],
            'media' => [
                'logo_url' => MediaUrl::toUrl($settings->logo),
                'hero_image_url' => MediaUrl::toUrl($settings->hero_image),
                'team_image_url' => MediaUrl::toUrl($settings->team_image),
                'developer_logo_url' => MediaUrl::toUrl($settings->developer_logo),
            ],
            'seo' => [
                'title' => $settings->seo_title,
                'description' => $settings->seo_description,
                'keywords' => $settings->seo_keywords,
            ],
            'map' => [
                'lat' => $settings->map_lat,
                'lng' => $settings->map_lng,
                'zoom' => $settings->map_zoom,
            ],
            'theme' => [
                'body_bg_color' => $settings->theme_body_bg ?: self::DEFAULT_THEME['body_bg_color'],
                'nav_bg_color' => $settings->theme_nav_bg ?: self::DEFAULT_THEME['nav_bg_color'],
                'accent_bg_color' => $settings->theme_accent_bg ?: self::DEFAULT_THEME['accent_bg_color'],
                'text_body_color' => $settings->theme_text_body ?: self::DEFAULT_THEME['text_body_color'],
                'text_secondary_color' => $settings->theme_text_secondary ?: self::DEFAULT_THEME['text_secondary_color'],
                'text_accent_color' => $settings->theme_text_accent ?: self::DEFAULT_THEME['text_accent_color'],
                'border_color' => $settings->theme_border_color ?: self::DEFAULT_THEME['border_color'],
            ],
            'og_image_url' => MediaUrl::toUrl($settings->og_image),
        ]);
    }
}
