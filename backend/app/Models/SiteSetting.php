<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'phone_1',
        'phone_2',
        'email',
        'address_main',
        'worktime_main',
        'social',
        'logo',
        'hero_image',
        'team_image',
        'developer_logo',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
        'map_lat',
        'map_lng',
        'map_zoom',
        'theme_body_bg',
        'theme_nav_bg',
        'theme_accent_bg',
        'theme_text_body',
        'theme_text_secondary',
        'theme_text_accent',
        'theme_border_color',
        'updated_by',
    ];

    protected $casts = [
        'social' => 'array',
        'map_lat' => 'float',
        'map_lng' => 'float',
        'map_zoom' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $model): void {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
