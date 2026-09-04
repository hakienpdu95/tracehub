<?php

namespace Modules\Assessment\Providers;

use Modules\Assessment\Console\Commands\AutoSuspendExpiredMembershipsCommand;
use Modules\Assessment\Console\Commands\FlagInactiveMembersCommand;
use Nwidart\Modules\Support\ModuleServiceProvider;

class AssessmentServiceProvider extends ModuleServiceProvider
{
    protected string $name      = 'Assessment';
    protected string $nameLower = 'assessment';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();
        $this->commands([
            AutoSuspendExpiredMembershipsCommand::class,
            FlagInactiveMembersCommand::class,
        ]);
    }
}
