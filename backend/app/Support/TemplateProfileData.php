<?php

namespace App\Support;

use InvalidArgumentException;

class TemplateProfileData
{
    public static function supportedProfiles(): array
    {
        return ['service', 'medical', 'corporate'];
    }

    public static function normalizeProfile(?string $profile): string
    {
        $normalized = strtolower(trim((string) $profile));

        return in_array($normalized, self::supportedProfiles(), true) ? $normalized : 'service';
    }

    public static function resolve(?string $profile = null): array
    {
        $normalized = self::normalizeProfile($profile);
        $path = base_path("database/seeders/profiles/{$normalized}.php");

        if (! is_file($path)) {
            throw new InvalidArgumentException("Unsupported template profile [{$normalized}].");
        }

        /** @var array $data */
        $data = require $path;

        return $data;
    }
}
