<?php

namespace Modules\Assessment\Providers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Assessment\Events\AssessmentCompleted;
use Modules\Assessment\Events\AssessmentFailed;
use Modules\Assessment\Events\HighDivergenceDetected;
use Modules\Assessment\Events\LowKpiAlert;
use Modules\Assessment\Listeners\LogAssessmentCompleted;
use Modules\Assessment\Listeners\UpdateTrustLevelOnEmailVerifiedListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Phase 0 — email verification → trust_level + identity_verifications
        Verified::class => [
            UpdateTrustLevelOnEmailVerifiedListener::class,
        ],

        AssessmentCompleted::class => [
            LogAssessmentCompleted::class,
        ],
        AssessmentFailed::class => [],
        LowKpiAlert::class => [],
        HighDivergenceDetected::class => [],
    ];

    protected static $shouldDiscoverEvents = false;

    protected function configureEmailVerification(): void {}
}
