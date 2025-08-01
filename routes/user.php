<?php

use Carbon\Carbon;
use App\Models\Sectoral;
use App\Models\Monitoring;
use Illuminate\Http\Request;
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


    // Display the data in sector chart when it selected
    Route::get('/chart/sector/data', function(Request $request) {
        $filter = $request->input('filter');

        $startDate = null;
        $endDate = Carbon::now();

        if($filter === 'today') {
            $startDate = Carbon::now()->startOfDay();
        }elseif ($filter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
        }elseif ($filter === 'year') {
            $startDate = Carbon::now()->startOfYear();
        }

        // Fetch data based on the date range
        $data = PersonalInformation::with(['remarkable', 'sectorName'])
                ->whereNull('deleted_at')
                ->whereBetween('date_intake', [$startDate, $endDate])
                ->get()
                ->groupBy('sectorName.name')
                ->map(function($items, $key) {
                    return [
                        'name' => $key,
                        'cash_assistance' => $items->sum('remarkable.cash_assistance'),
                    ];
                })->values();

        return response()->json(['data' => $data]);
    });


    // Display the data in assistance chart when it selected
    Route::get('/chart/assistance/data', function(Request $request) {
         $filter = $request->input('filter');

        $startDate = null;
        $endDate = Carbon::now();

        if ($filter === 'today'){
            $startDate = Carbon::now()->startOfDay();
        }elseif ($filter === 'month'){
            $startDate = Carbon::now()->startOfMonth();
        }elseif ($filter === 'year'){
            $startDate = Carbon::now()->startOfYear();
        }

        // Fetch data based on the date range
        $data = PersonalInformation::with(['remarkable', 'assistance'])
            ->whereNull('deleted_at')
            ->whereBetween('date_intake', [$startDate, $endDate])
            ->get()
            ->groupBy('assistance.name')
            ->map(function ($items, $key) {
                return [
                    'name' => $key,
                    'cash_assistance' => $items->sum('remarkable.cash_assistance'),
                ];
            })
            ->values();

        return response()->json(['data' => $data]);
    });


    // Display the data in municipal chart when it selected
    Route::get('/chart/municipality/data', function(Request $request) {
        $filter = $request->input('filter');

        // Define the date range based on the filter
        $startDate = null;
        $endDate = Carbon::now();

        if ($filter === 'today') {
            $startDate = Carbon::now()->startOfDay();
        } elseif ($filter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
        } elseif ($filter === 'year') {
            $startDate = Carbon::now()->startOfYear();
        }

        // Fetch data based on the date range
        $data = PersonalInformation::with(['remarkable', 'municipal'])
            ->whereNull('deleted_at')
            ->whereBetween('date_intake', [$startDate, $endDate])
            ->get()
            ->groupBy('municipal.municipality')
            ->map(function ($items, $key) {
                return [
                    'municipality' => $key,
                    'cash_assistance' => $items->sum('remarkable.cash_assistance'),
                ];
            })
            ->values();

        return response()->json(['data' => $data]);
    });
});
