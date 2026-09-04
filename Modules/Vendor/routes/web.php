<?php

use Illuminate\Support\Facades\Route;
use Modules\Vendor\Http\Controllers\VendorCertificateController;
use Modules\Vendor\Http\Controllers\VendorController;

Route::middleware(['auth'])->prefix('dashboard')->name('backend.')->group(function () {
    Route::resource('vendors', VendorController::class);

    Route::post('vendors/{vendor}/certificates', [VendorCertificateController::class, 'store'])
        ->name('vendors.certificates.store');
    Route::delete('vendors/{vendor}/certificates/{certificate}', [VendorCertificateController::class, 'destroy'])
        ->name('vendors.certificates.destroy');
});
