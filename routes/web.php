<?php

use App\Models\AssistanceType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\IntakeController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\SectoralDataController;
use App\Http\Controllers\Admin\UserRegisterController;
use App\Http\Controllers\Admin\TypeAssistanceController;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;

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


// Auth::routes();

Route::get('/login', function() {
    return redirect()->to('/login-page');
})->name('login');

Route::get('/login-page', function() {
    return view('login');
});

Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->name('logout.post');

Route::post('/login-post', [AuthController::class, 'login'])->name('login.post');

Route::get('/', function() {
    return inertia('LayoutApp');
})->name('home')->middleware('auth');

Route::get('/dashboard', function() {
    return inertia('Dashboard');
})->middleware('auth');

Route::group(['middleware' => 'auth'], function() {

    // Register User Controller
    Route::controller(UserRegisterController::class)
            ->group(function() {
                Route::get('/user-registration/index', 'index')->name('user.index');
                Route::get('/user-registration/create', 'createUser')->name('user.create');
                Route::post('/user/post', 'store')->name('user.store');
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
                Route::get('/intake/export/{id}', 'export')->name('intake.export');
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

    // Type Assistance Controller
    Route::controller(TypeAssistanceController::class)
            ->group(function() {
                Route::get('/type-assistance', 'index');
                Route::get('/type-assistance/create', 'create')->name('assistance.create');
                Route::post('/type-assistance/post', 'store')->name('assistance.post');
    });

    // Municipality Controller
    Route::get('/municipality', function() {
        return inertia('Municipality');
    });

    // Barangay Controller
    Route::get('/barangay', function() {
        return inertia('Barangay');
    });

    // Sector Controller
    Route::controller(SectorController::class)
            ->group(function() {
                Route::get('/sector', 'index');
                Route::get('/sector/create', 'create')->name('sector.create');
                Route::post('/sector/post', 'store')->name('sector.store');
    });

    // Staff Administrator Controller
    Route::get('/staff-admin', function() {
        return inertia('StaffAdmin');
    });

    // Liaison Controller
    Route::get('/liaison', function() {
        return inertia('Liaison');
    });

    // Office Charges Controller
    Route::get('/office-charges', function() {
        return inertia('OfficeCharges');
    });

});





