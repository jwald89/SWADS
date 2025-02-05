<?php

use App\Enums\Month;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IntakeController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\SectoralDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * Fetch data from the monitoring datatable
 */
Route::get('/monitoring-records', [MonitoringController::class, 'getMonitoringRecords']);


/**
 *  Fetch data from family_composition datatable to display on monitoring module in beneficiary input field
 */
Route::get('/fetch-beneficiaries', [MonitoringController::class, 'fetchBeneficiaries']);


/**
 * Discard the process in intake module and delete data on database table
 */
Route::delete('remove-records', [IntakeController::class, 'deleteRecords']);


// Route::get('/sectoral-data/filter/{sector?}/{municipality?}', [SectoralDataController::class, 'filter']);
