<?php

use App\Models\AssistanceType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IntakeController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\LiaisonController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\Admin\BarangayController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\StaffAdminController;
use App\Http\Controllers\Admin\MunicipalityController;
use App\Http\Controllers\Admin\SectoralDataController;
use App\Http\Controllers\Admin\UserRegisterController;
use App\Http\Controllers\Admin\OfficeChargesController;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;
use App\Http\Controllers\Admin\TypeAssistanceController;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;

Route::redirect('/login', '/login-page')->name('login');
Route::get('/login-page', fn() => view('login'));

Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->name('logout.post');
Route::post('/login-post', [AuthController::class, 'login'])->name('login.post');

Route::get('/', AuthenticatedController::class)->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::controller(DashboardController::class)
    ->group(function() {
        Route::get('/dashboard', 'index');
    });
});

Route::group(['middleware' => 'auth'], function() {

    // Register User Controller
    Route::controller(UserRegisterController::class)
            ->group(function() {
                Route::get('/user-registration/index', 'index')->name('user.index');
                Route::get('/user-registration/create', 'createUser')->name('user.create')->middleware([EnsureFeaturesAreActive::using('administrator')]);
                Route::post('/user/post', 'store')->name('user.store');
    });

    // Intake Controller
    Route::controller(IntakeController::class)
            ->group(function() {
                Route::get('/intake', 'index')->middleware([
                    EnsureFeaturesAreActive::using('allowed-multiple-roles'),
                ]);
                Route::get('/intake/create', 'create')->name('intake.create');

                // Store the data from the form
                Route::post('/intake/create-post/p1', 'storeP1')->name('intake.post1')->middleware('validate.client.record');
                Route::post('/intake/create-post/p2', 'storeP2')->name('intake.post2');
                Route::post('/intake/create-post/p3', 'storeP3')->name('intake.post3');
                Route::post('/intake/create-post/p4', 'storeP4')->name('intake.post4');

                // Display the data
                Route::get('/intake/show/{id}', 'show')->name('intake.show');

                // Display the data in edit-form
                Route::get('/intake/edit/{id}', 'edit')->name('intake.edit');

                Route::put('/intake/edit/p1/{id}', 'update');
                Route::put('/intake/edit/p2/{id}', 'editP2')->name('intake.editP2');
                Route::put('/intake/edit/p3/{id}', 'editP3')->name('intake.editP3');
                Route::put('/intake/edit/p4/{id}', 'editP4')->name('intake.editP4');

                Route::get('/intake/print/{id}', 'print')->name('intake.print');
                Route::get('/intake/export/{id}', 'export')->name('intake.export');
    });

    // Monitoring Controller
    Route::controller(MonitoringController::class)
            ->group(function() {
                Route::get('/monitoring', 'index');
                Route::get('/monitoring/create', 'create');
                Route::post('/monitoring/create-post', 'store');
                Route::get('/monitoring/edit/{id}', 'edit');
                Route::put('/monitoring/update/{id}', 'update');
    });

    // Sectoral Data Controller
    Route::controller(SectoralDataController::class)
            ->group(function() {
                Route::get('/sectoral-data', 'index');
                Route::get('/sectoral/create', 'create')->name('sectoral.create');
                Route::post('/sectoral-data/create-post', 'store');
                Route::get('/sectoral/edit/{id}', 'edit');
                Route::put('/sectoral-data/update/{id}', 'update');
    });

    // Type Assistance Controller
    Route::controller(TypeAssistanceController::class)
            ->group(function() {
                Route::get('/type-assistance', 'index');
                Route::get('/type-assistance/create', 'create')->name('assistance.create');
                Route::post('/type-assistance/post', 'store')->name('assistance.post');
    });

    // Municipality Controller
    Route::controller(MunicipalityController::class)
            ->group(function() {
                Route::get('/municipality', 'index');
                Route::get('/municipality/create', 'create')->name('municipality.create');
                Route::post('/municipality/post', 'store')->name('municipality.post');
            });

    // Barangay Controller
    Route::controller(BarangayController::class)
            ->group(function() {
                Route::get('/barangay', 'index');
                Route::get('/barangay/create', 'create')->name('barangay.create');
                Route::post('/barangay/post', 'store')->name('barangay.post');
    });

    // Sector Controller
    Route::controller(SectorController::class)
            ->group(function() {
                Route::get('/sectors', 'index');
                Route::get('/sectors/create', 'create')->name('sector.create');
                Route::post('/sectors/post', 'store')->name('sector.post');
    });

    // Staff Administrator Controller
    Route::controller(StaffAdminController::class)
            ->group(function() {
                Route::get('/staff-admin', 'index');
                Route::get('/staff-admin/create', 'create')->name('staff.create');
                Route::post('/staff-admin/post', 'store')->name('staff.post');
    });

    // Liaison Controller
    Route::controller(LiaisonController::class)
            ->group(function() {
                Route::get('/liaison', 'index');
                Route::get('/liaison/create', 'create')->name('liaison.create');
                Route::post('/liaison/post', 'store')->name('liaison.post');
    });


    // Office Charges Controller
    Route::controller(OfficeChargesController::class)
            ->group(function() {
                Route::get('/office-charges', 'index');
                Route::get('/office-charges/create', 'create')->name('office.create');
                Route::post('/office-charges/post', 'store')->name('office.post');
    });
});


