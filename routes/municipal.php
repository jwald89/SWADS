<?php

use App\Models\Sectoral;
use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;




Route::group(['prefix' => 'municipal', 'middleware' => [
    EnsureFeaturesAreActive::using('municipal')]
], function () {
    Route::get('/dashboard', function () {
        return inertia('Municipal/Dashboard');
    });

    Route::get('/edit-municipal/{id}', function($id) {
        $sectoral = Sectoral::with(['municipality', 'barangay', 'user', 'sector'])->findOrFail($id);

        return inertia('Municipal/EditMunicipal', [
            'sectoral' => $sectoral
        ]);
    });

})->middleware(EnsureFeaturesAreActive::using('municipal'));
