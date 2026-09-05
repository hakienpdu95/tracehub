<?php

use Illuminate\Support\Facades\Route;
use Modules\Compliance\Http\Controllers\ComplianceWarningController;

Route::middleware(['auth'])->prefix('dashboard')->name('backend.')->group(function () {
    Route::get('compliance-warnings', [ComplianceWarningController::class, 'index'])->name('compliance-warnings.index');
    Route::post('compliance-warnings/{warning}/acknowledge', [ComplianceWarningController::class, 'acknowledge'])->name('compliance-warnings.acknowledge');
    Route::post('compliance-warnings/{warning}/resolve', [ComplianceWarningController::class, 'resolve'])->name('compliance-warnings.resolve');
});
