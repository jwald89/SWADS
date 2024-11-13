<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;




Route::group(['prefix' => 'user','middleware' => [
    EnsureFeaturesAreActive::using('user')]
], function () {
    Route::get('/dashboard', function () {
        $totalAssistance = DB::table('personal_information')->count();
        $totalAmt = DB::table('monitorings')->sum('amount');
        $monitorData = DB::table('monitorings')
            ->select('claimant', 'municipality', 'assistance_type', 'amount')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
            ->get();

        $status = DB::table('monitorings')->select('claimant', 'date_intake', 'sector', 'charges', 'amount', 'status')->get();

        return inertia('User/Dashboard', [
            'totalNums' => $totalAssistance,
            'totalAmt' => $totalAmt,
            'monitorings' => $monitorData,
            'monitorStatus' => $status
        ]);
    });
});
