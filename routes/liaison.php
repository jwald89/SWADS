<?php

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
});
