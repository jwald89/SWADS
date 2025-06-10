<?php

use Carbon\Carbon;
use App\Models\Sectoral;
use App\Models\Monitoring;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;


Route::group(['prefix' => 'user','middleware' => [
    EnsureFeaturesAreActive::using('user')]
], function () {
    Route::get('/dashboard', function () {
        $totalAssistance = DB::table('personal_information')->whereNull('deleted_at')->count();
        // $totalAmt = DB::table('monitorings')->where('deleted_at', null)->sum('amount');
        $totalAmt = DB::table('remarks')->where('deleted_at', null)->sum('cash_assistance');
        $monitorData = Monitoring::with(['intake', 'assistance', 'municipal'])
                        ->whereHas('intake', function($query) {
                            $query->where('deleted_at', null);
                        })
                        ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
                        ->get();

        $totalSectors = Sectoral::count();
        $totalMonitors = Monitoring::where('deleted_at', NULL)->count();
        $sumOfSectors = $totalMonitors + $totalSectors;

        // $status = Monitoring::with(['intake', 'sectorName', 'assistance', 'municipal', 'chargingOffice'])->orderByDesc('date_intake')
        //                     ->whereHas('intake', function($query) {
        //                         $query->where('deleted_at', null);
        //                     })
        //                     ->orderByDesc('date_intake')
        //                     ->get();

        $status = PersonalInformation::with(['remarkable', 'sectorName', 'assistance', 'municipal', 'chargingOffice'])
                ->whereNull('deleted_at')
                ->orderByDesc('date_intake')
                ->get();

        return inertia('User/Dashboard', [
            'totalNums' => $totalAssistance,
            'totalAmt' => $totalAmt,
            'monitorings' => $monitorData,
            'monitorStatus' => $status,
            'sectorAvg' => $sumOfSectors,
        ]);
    });
});
