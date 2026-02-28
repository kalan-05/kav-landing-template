<?php

namespace Tests\Feature\Api;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_endpoint_returns_200_and_contract_fields(): void
    {
        SiteSetting::query()->create([
            'site_name' => '???????? ????',
            'phone_1' => '+79990000000',
            'email' => 'test@example.com',
            'social' => ['tg' => 'https://t.me/test'],
            'map_zoom' => 14,
        ]);

        $response = $this->getJson('/api/settings');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'site_name',
                'phones',
                'email',
                'address_main',
                'worktime_main',
                'social',
                'media' => ['logo_url', 'hero_image_url', 'team_image_url', 'developer_logo_url'],
                'seo' => ['title', 'description', 'keywords'],
                'map' => ['lat', 'lng', 'zoom'],
                'theme' => [
                    'body_bg_color',
                    'nav_bg_color',
                    'accent_bg_color',
                    'text_body_color',
                    'text_secondary_color',
                    'text_accent_color',
                    'border_color',
                ],
                'og_image_url',
            ]);
    }
}
