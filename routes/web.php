<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function() {
    return inertia('LayoutApp');
});

Route::get('/dashboard', function() {
    return inertia('Dashboard');
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

Route::get('/intake', function() {
    return inertia('IntakeIndex');
});


Route::get('/monitoring', function() {
    return inertia('MonitoringIndex');
});

Route::get('/monitoring/create', function() {
    return inertia('MonitoringCreate');
});

Route::get('/intake/create', function(){
    return inertia('IntakeCreate');
});
