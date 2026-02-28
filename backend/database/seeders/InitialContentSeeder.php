<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\GalleryItem;
use App\Models\PageBlock;
use App\Models\Review;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\TemplateProfileData;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialContentSeeder extends Seeder
{
    protected ?string $profile = null;

    protected bool $resetExisting = false;

    public function forProfile(?string $profile): static
    {
        $this->profile = TemplateProfileData::normalizeProfile($profile);

        return $this;
    }

    public function withReset(bool $reset = true): static
    {
        $this->resetExisting = $reset;

        return $this;
    }

    public function run(): void
    {
        $profile = TemplateProfileData::normalizeProfile($this->profile ?? config('template.profile'));
        $data = TemplateProfileData::resolve($profile);

        DB::transaction(function () use ($data): void {
            if ($this->resetExisting) {
                Review::query()->delete();
                Doctor::query()->delete();
                Service::query()->delete();
                GalleryItem::query()->delete();
                PageBlock::query()->delete();
                SiteSetting::query()->delete();
            }

            SiteSetting::query()->updateOrCreate(
                ['id' => 1],
                $data['site']
            );

            foreach ($data['blocks'] as $block) {
                PageBlock::query()->updateOrCreate(['key' => $block['key']], $block);
            }

            $doctorIdsByName = [];

            foreach ($data['team'] as $index => $doctorData) {
                $doctor = Doctor::query()->updateOrCreate(
                    ['full_name' => $doctorData['full_name']],
                    [
                        'full_name' => $doctorData['full_name'],
                        'position' => $doctorData['position'],
                        'regalia' => $doctorData['regalia'],
                        'description' => $doctorData['description'],
                        'photo' => null,
                        'sort_order' => ($index + 1) * 10,
                        'is_active' => true,
                    ]
                );

                $doctorIdsByName[$doctor->full_name] = $doctor->id;
            }

            foreach ($data['services'] as $index => $serviceData) {
                Service::query()->updateOrCreate(
                    ['title' => $serviceData['title']],
                    [
                        'title' => $serviceData['title'],
                        'group' => $serviceData['group'],
                        'sort_order' => ($index + 1) * 10,
                        'is_active' => true,
                    ]
                );
            }

            foreach ($data['gallery'] as $index => $galleryItem) {
                GalleryItem::query()->updateOrCreate(
                    ['caption' => $galleryItem['caption']],
                    [
                        'image' => null,
                        'caption' => $galleryItem['caption'],
                        'alt' => $galleryItem['alt'],
                        'sort_order' => ($index + 1) * 10,
                        'is_active' => true,
                    ]
                );
            }

            foreach ($data['reviews'] as $index => $reviewData) {
                Review::query()->updateOrCreate(
                    ['author_name' => $reviewData['author_name'], 'text' => $reviewData['text']],
                    [
                        'author_name' => $reviewData['author_name'],
                        'rating' => $reviewData['rating'],
                        'text' => $reviewData['text'],
                        'source' => 'manual',
                        'status' => 'published',
                        'published_at' => CarbonImmutable::now()->subDays(max(0, 3 - $index)),
                        'doctor_id' => $doctorIdsByName[$reviewData['doctor_name']] ?? null,
                        'author_contacts' => null,
                        'meta' => null,
                    ]
                );
            }
        });
    }
}
