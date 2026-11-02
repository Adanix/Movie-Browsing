<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DemoResetCommand extends Command
{
    protected $signature = 'demo:reset';
    protected $description = 'Safely reset and re-seed Matinee demo dataset aligned with current dates';

    public function handle(): int
    {
        if (app()->environment('production') && !config('demo.enabled', true)) {
            $this->error('Aborting: demo:reset cannot run in live production environment.');
            return 1;
        }

        $this->info('Resetting database and running migrations...');
        Artisan::call('migrate:fresh', ['--force' => true]);

        $this->info('Seeding multi-city Matinee cinema dataset...');
        Artisan::call('db:seed', ['--force' => true]);

        $this->info('Clearing configuration cache...');
        Artisan::call('optimize:clear');

        $this->info('Matinee Cinema Platform demo has been reset successfully.');
        return 0;
    }
}
