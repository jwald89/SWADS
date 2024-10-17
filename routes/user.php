<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;




Route::group(['prefix' => 'user','middleware' => [
    EnsureFeaturesAreActive::using('user')]
], function () {
    Route::get('/dashboard', function () {
        return inertia('User/Dashboard');
    });
});
