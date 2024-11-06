<?php

use App\Models\Monitoring;
use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

Route::group([
    'prefix' => 'liaison',
    'middleware' => [
        EnsureFeaturesAreActive::using('liaison')]
    ],
    function () {
        Route::get('/dashboard', function () {
            return inertia('Liaison/Dashboard');
        });
        Route::get('/edit-liaison/{id}', function ($id) {
            $monitoring = Monitoring::with(['user'])->findOrFail($id);

            return inertia('Liaison/EditLiaison', [
                'monitoring' => $monitoring
            ]);
        });
});
