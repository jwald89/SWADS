<?php

use Carbon\Carbon;
use App\Models\Sector;
use App\Models\Barangay;
use App\Models\Sectoral;
use App\Models\Monitoring;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\SectorResource;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\MunicipalityResource;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

Route::group(['prefix' => 'municipal', 'middleware' => [
    EnsureFeaturesAreActive::using('municipal')]
], function () {
    Route::get('/dashboard', function () {
        $totalAssistance = DB::table('personal_information')->count();
        $totalAmt = DB::table('monitorings')->sum('amount');
        $monitorData = Monitoring::with(['intake', 'assistance'])
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
                    ->get();
        $totalSectors = Sectoral::count();
        $totalMonitors = Monitoring::where('deleted_at', NULL)->count();
        $sumOfSectors = $totalMonitors + $totalSectors;

        $status = Monitoring::with(['intake', 'sector'])->get();

        return inertia('Municipal/Dashboard',  [
            'totalNums' => $totalAssistance,
            'totalAmt' => $totalAmt,
            'monitorings' => $monitorData,
            'monitorStatus' => $status,
            'sectorAvg' => $sumOfSectors,
        ]);
    });

    Route::get('/sectoral/edit/{id}', function($id) {
        $sectoral = Sectoral::findOrFail($id);

        $sectors = SectorResource::collection(Sector::all());
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());

        return inertia('Municipal/EditMunicipal', [
            'sectoral' => $sectoral,
            'sectors' => $sectors,
            'municipality' => $municipality,
            'barangays' => $barangays
        ]);
    });

    Route::put('/sectoral/update/{id}', function(Request $request, $id) {
        $monitoring = Sectoral::with(['municipality', 'user', 'sector'])->findOrFail($id);

        $monitoring->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return response()->json(['success' => true]);
    });

})->middleware(EnsureFeaturesAreActive::using('municipal'));
