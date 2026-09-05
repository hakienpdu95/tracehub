<?php

namespace Modules\Sapo\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Sapo\Console\Commands\ReconcileSapoOrdersCommand;
use Nwidart\Modules\Support\ModuleServiceProvider;

class SapoServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Sapo';

    protected string $nameLower = 'sapo';

    protected array $providers = [
        RouteServiceProvider::class,
    ];

    protected array $commands = [
        ReconcileSapoOrdersCommand::class,
    ];

    public function register(): void
    {
        parent::register();
    }

    public function boot(): void
    {
        parent::boot();
    }

    protected function configureSchedules(Schedule $schedule): void
    {
        $schedule->command('sapo:reconcile-orders')
            ->name('sapo:reconcile-orders')
            ->dailyAt('23:00')
            ->onOneServer();
    }
}
