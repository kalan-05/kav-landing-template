<?php

namespace App\Console\Commands;

use App\Models\PageBlock;
use App\Models\SiteSetting;
use App\Support\TemplateProfileData;
use Database\Seeders\InitialContentSeeder;
use Illuminate\Console\Command;

class SeedTemplateProfileCommand extends Command
{
    protected $signature = 'template:seed-demo
        {profile? : service|medical|corporate}
        {--fresh : Remove existing demo content before seeding}
        {--force : Skip confirmation when replacing existing content}';

    protected $description = 'Seed demo content for the selected template profile';

    public function handle(): int
    {
        $requested = (string) ($this->argument('profile') ?: config('template.profile'));
        $profile = TemplateProfileData::normalizeProfile($requested);
        $fresh = (bool) $this->option('fresh');

        if ($requested !== $profile) {
            $this->warn(sprintf(
                'Unknown profile "%s". Fallback to "%s". Supported: %s.',
                $requested,
                $profile,
                implode(', ', TemplateProfileData::supportedProfiles())
            ));
        }

        if ($fresh && $this->hasExistingContent() && ! $this->option('force')) {
            if (! $this->confirm('This will replace current demo content. Continue?', false)) {
                $this->line('Seeding cancelled.');

                return self::SUCCESS;
            }
        }

        config(['template.profile' => $profile]);

        app(InitialContentSeeder::class)
            ->forProfile($profile)
            ->withReset($fresh)
            ->run();

        $this->info(sprintf('Demo content seeded for profile [%s].', $profile));

        return self::SUCCESS;
    }

    protected function hasExistingContent(): bool
    {
        return SiteSetting::query()->exists() || PageBlock::query()->exists();
    }
}
