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

Route::get('/register', function() {
    return inertia('Register');
});
