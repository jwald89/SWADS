<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IntakeController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\SectoralDataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function() {
    return inertia('LayoutApp');
});

Route::get('/dashboard', function() {
    return inertia('Dashboard');
});

// Intake Controller
Route::controller(IntakeController::class)
        ->group(function() {
            Route::get('/intake', 'index');
            Route::get('/intake/create', 'create')->name('intake.create');
            Route::post('/intake/create-post/p1', 'storeP1')->name('intake.post1');
            Route::post('/intake/create-post/p2', 'storeP2')->name('intake.post2');
            Route::post('/intake/create-post/p3', 'storeP3')->name('intake.post3');
            Route::post('/intake/create-post/p4', 'storeP4')->name('intake.post4');
            Route::get('/intake/show/{id}', 'show')->name('intake.show');
            Route::get('/intake/edit/{id}', 'edit')->name('intake.edit');
            Route::post('/intake/edit/p1/{id}', 'editP1')->name('intake.editP1');
            Route::post('/intake/edit/p2/{id}', 'editP2')->name('intake.editP2');
            Route::post('/intake/edit/p3/{id}', 'editP3')->name('intake.editP3');
            Route::post('/intake/edit/p4/{id}', 'editP4')->name('intake.editP4');
            Route::get('/intake/print/{id}', 'print')->name('intake.print');
        });

// Monitoring Controller
Route::controller(MonitoringController::class)
        ->group(function() {
            Route::get('/monitoring', 'index');
            Route::get('/monitoring/create', 'create');
            Route::post('/monitoring/create-post', 'store');
        });

// Sectoral Data Controller
Route::controller(SectoralDataController::class)
        ->group(function() {
            Route::get('/sectoral-data', 'index');
        });




Route::get('/profile', function() {
    return inertia('Profile');
});

Route::get('/login', function() {
    return inertia('Login');
});

Route::get('/type-assistance', function() {
    return inertia('TypeAssistance');
});

Route::get('/municipality', function() {
    return inertia('Municipality');
});

Route::get('/barangay', function() {
    return inertia('Barangay');
});

Route::get('/sector', function() {
    return inertia('Sector');
});

Route::get('/staff-admin', function() {
    return inertia('StaffAdmin');
});

Route::get('/liaison', function() {
    return inertia('Liaison');
});

Route::get('/office-charges', function() {
    return inertia('OfficeCharges');
});
