<?php

use Illuminate\Support\Facades\Route;
use Modules\Sapo\Http\Controllers\SapoOrderWebhookController;

Route::post('webhooks/sapo/{org_id}/orders-create', [SapoOrderWebhookController::class, 'handle'])
    ->name('webhooks.sapo.orders-create');
