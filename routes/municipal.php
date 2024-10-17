<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;




Route::group(['prefix' => 'municipal', 'middleware' => [
    EnsureFeaturesAreActive::using('municipal')]
], function () {
    Route::get('/dashboard', function () {
        return inertia('Municipal/Dashboard');
    });

})->middleware(EnsureFeaturesAreActive::using('municipal'));
