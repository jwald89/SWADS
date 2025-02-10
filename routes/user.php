<?php

use Carbon\Carbon;
use App\Models\Sectoral;
use App\Models\Monitoring;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;


Route::group(['prefix' => 'user','middleware' => [
    EnsureFeaturesAreActive::using('user')]
], function () {
    Route::get('/dashboard', function () {
        $totalAssistance = DB::table('personal_information')->whereNull('deleted_at')->count();
        $totalAmt = DB::table('monitorings')->where('deleted_at', null)->sum('amount');
        $monitorData = Monitoring::with(['intake', 'assistance'])
                        ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
                        ->get();

        $totalSectors = Sectoral::count();
        $totalMonitors = Monitoring::where('deleted_at', NULL)->count();
        $sumOfSectors = $totalMonitors + $totalSectors;

        $status = Monitoring::with(['intake', 'sector', 'assistance'])->get();

        return inertia('User/Dashboard', [
            'totalNums' => $totalAssistance,
            'totalAmt' => $totalAmt,
            'monitorings' => $monitorData,
            'monitorStatus' => $status,
            'sectorAvg' => $sumOfSectors,
        ]);
    });
});
