<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\BrandController;
use Modules\Product\Http\Controllers\DocumentMasterTypeController;
use Modules\Product\Http\Controllers\ProductComplianceController;
use Modules\Product\Http\Controllers\ProductController;

Route::middleware(['auth'])->prefix('dashboard')->name('backend.')->group(function () {
    Route::resource('products', ProductController::class);

    Route::post('products/{product}/compliances', [ProductComplianceController::class, 'store'])
        ->name('products.compliances.store');
    Route::delete('products/{product}/compliances/{compliance}', [ProductComplianceController::class, 'destroy'])
        ->name('products.compliances.destroy');

    Route::resource('brands', BrandController::class)->only(['index', 'store', 'destroy']);

    Route::resource('document-master-types', DocumentMasterTypeController::class)->except(['show']);
});
