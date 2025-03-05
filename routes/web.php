<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\IntakeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\Admin\BarangayController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\MunicipalityController;
use App\Http\Controllers\Admin\SectoralDataController;
use App\Http\Controllers\Admin\UserRegisterController;
use App\Http\Controllers\Admin\OfficeChargesController;
use App\Http\Controllers\Admin\SummaryReportController;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;
use App\Http\Controllers\Admin\TypeAssistanceController;
use App\Http\Controllers\Admin\ChildDevelopmentController;
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
                Route::get('/user-registration/create', 'create')->name('user.create');
                Route::post('/user/post', 'store')->name('user.store');
                Route::get('/user/edit/{id}', 'edit');
                Route::put('/user/update/{id}', 'update');
    })->middleware([EnsureFeaturesAreActive::using('administrator')]);

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
                Route::post('/intake/create-post/null/p2', 'storeP2Null');
                Route::post('/intake/create-post/p3', 'storeP3')->name('intake.post3');
                Route::post('/intake/create-post/p4', 'storeP4')->name('intake.post4');

                // Display the data
                Route::get('/intake/show/{id}', 'show')->name('intake.show');

                // Display the data in edit-form
                Route::get('/intake/edit/{id}', 'edit')->name('intake.edit');

                // Update data in edit-form
                Route::put('/intake/update/{id}', 'update');

                // Print and download process
                Route::get('/intake/intake-sheet-print/{id}', 'intakeSheetPrint')->name('intake.print');
                Route::get('/intake/export/{id}', 'export')->name('intake.export');
                Route::get('/intake/print-coe/{id}', 'coePrint');

                Route::get('/intake/filter/{assistanceId?}/{municipalId?}/{month?}', 'filter');
    });

    // Monitoring Controller
    Route::controller(MonitoringController::class)
            ->group(function() {
                Route::get('/monitoring', 'index');
                Route::get('/monitoring/create', 'create');
                Route::post('/monitoring/create-post', 'store');
                Route::get('/monitoring/edit/{id}', 'edit');
                Route::put('/monitoring/update/{id}', 'update');
                Route::delete('/monitoring/destroy/{id}', 'destroy');
                Route::get('/monitoring/show/{id}', 'show');
                Route::get('/monitoring/filter/{assistanceId?}/{sectorId?}/{municipalName?}/{month?}', 'filter');
    });

    // Sectoral Data Controller
    Route::controller(SectoralDataController::class)
            ->group(function() {
                Route::get('/sectoral-data', 'index');
                Route::get('/sectoral-data/create', 'create')->name('sectoral.create');
                Route::post('/sectoral-data/create-post', 'store');
                Route::get('/sectoral-data/edit/{id}', 'edit');
                Route::put('/sectoral-data/update/{id}', 'update');
                Route::get('/sectoral-data/filter/{sectorId?}/{municipalId?}/{month?}', 'filter');
                Route::get('/sectoral-data/show/{id}', 'show');
    });

    // Child Development Controller
    Route::controller(ChildDevelopmentController::class)
            ->group(function() {
                Route::get('/child-development', 'index');
                Route::get('/child-development/create', 'create');
                Route::post('/child-development/post', 'store');
                Route::get('/child-development/edit/{id}', 'edit');
                Route::put('/child-development/update/{id}', 'update');
                Route::get('/child-development/filter/{brgyId?}/{municipalId?}/{month?}', 'filter');
    });


    // Type Assistance Controller
    Route::controller(TypeAssistanceController::class)
            ->group(function() {
                Route::get('/type-assistance', 'index');
                Route::post('/type-assistance/post', 'store')->name('assistance.post');
                Route::get('/type-assistance/edit/{id}', 'edit');
                Route::put('/type-assistance/update/{id}', 'update')->name('assistance.update');
    });

    // Municipality Controller
    Route::controller(MunicipalityController::class)
            ->group(function() {
                Route::get('/municipality', 'index');
                Route::post('/municipality/post', 'store')->name('municipality.post');
                Route::get('/municipality/edit/{id}', 'edit');
                Route::put('/municipality/edit/{id}', 'update')->name('municipality.update');
            });

    // Barangay Controller
    Route::controller(BarangayController::class)
            ->group(function() {
                Route::get('/barangay', 'index');
                Route::post('/barangay/post', 'store')->name('barangay.post');
    });

    // Sector Controller
    Route::controller(SectorController::class)
            ->group(function() {
                Route::get('/sectors', 'index');
                Route::post('/sectors/post', 'store')->name('sector.post');
                Route::get('/sectors/edit/{id}', 'edit');
                Route::put('/sectors/edit/{id}', 'update');
    });

    // Office Charges Controller
    Route::controller(OfficeChargesController::class)
            ->group(function() {
                Route::get('/office-charges', 'index');
                Route::post('/office-charges/post', 'store')->name('office.post');
                Route::get('/office-charges/edit/{id}', 'edit');
                Route::put('/office-charges/edit/{id}', 'update');
    });

    // Chart Reports
    Route::controller(ReportController::class)
        ->group(function() {
            Route::get('/aics-coe-served', 'intakeSheetServed');
            Route::get('/aics-per-municipal', 'perMunicipality');
            Route::get('/aics-served-per-sectoral', 'servedPerSectoral');
            Route::get('/aics-per-sectoral-group', 'perSectoral');
        });

    Route::controller(SummaryReportController::class)
        ->group(function() {
            Route::get('/summary-report', 'index');
            Route::get('/summary-report/filter/{assistanceId?}/{sectorId?}/{municipalId?}/{officeId?}/{dateFrom?}/{dateTo?}', 'filter');
        });
});




