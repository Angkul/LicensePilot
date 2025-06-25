<?php

use App\Http\Controllers\Api\LicenseController;

Route::get('/ping', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/license/validate', [LicenseController::class, 'validate']);
Route::post('/license/deactivate', [LicenseController::class, 'deactivate']);
Route::get('/license/activations', [LicenseController::class, 'activations']);
Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});
