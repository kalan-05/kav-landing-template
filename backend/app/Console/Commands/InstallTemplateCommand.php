<?php

namespace App\Console\Commands;

use App\Models\PageBlock;
use App\Models\SiteSetting;
use App\Support\TemplateProfileData;
use Illuminate\Console\Command;

class InstallTemplateCommand extends Command
{
    protected $signature = 'template:install
        {profile? : service|medical|corporate}
        {--fresh : Replace existing demo content with the selected profile}
        {--force : Skip confirmation when replacing existing content}';

    protected $description = 'Install template database and seed the selected profile';

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
            if (! $this->confirm('This will replace current content with the selected profile. Continue?', false)) {
                $this->line('Installation cancelled.');

                return self::SUCCESS;
            }
        }

        config(['template.profile' => $profile]);

        if (blank(config('app.key'))) {
            $this->call('key:generate', ['--force' => true]);
        }

        $this->call('migrate', ['--force' => true]);
        $this->call('template:seed-demo', [
            'profile' => $profile,
            '--fresh' => $fresh,
            '--force' => true,
        ]);

        if (! file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }

        $this->call('optimize:clear');

        $this->info(sprintf('Template installed with profile [%s].', $profile));

        return self::SUCCESS;
    }

    protected function hasExistingContent(): bool
    {
        return SiteSetting::query()->exists() || PageBlock::query()->exists();
    }
}
