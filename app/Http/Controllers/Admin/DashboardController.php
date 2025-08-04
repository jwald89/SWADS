<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sectoral;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalAssistance = DB::table('personal_information')->whereNull('deleted_at')->count();
        // $totalAmt = DB::table('monitorings')->where('deleted_at', null)->sum('amount');
        $totalAmt = DB::table('remarks')->whereNull('deleted_at')->sum('cash_assistance');
        $monitorData = Monitoring::with(['intake', 'assistance', 'municipal'])
                            ->whereHas('intake', function($query) {
                                $query->where('deleted_at', null);
                            })
                            ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
                            ->get();

        $totalSectors = Sectoral::count();
        $totalMonitors = Monitoring::where('deleted_at', null)->count();
        $sumOfSectors = $totalMonitors + $totalSectors;

        $parseTotalAmt = number_format($totalAmt, 2, ".", ",");

        // $status = Monitoring::with(['intake', 'sectorName', 'assistance', 'municipal', 'chargingOffice'])
        //         ->whereHas('intake', function($query) {
        //             $query->where('deleted_at', null);
        //         })
        //         ->orderByDesc('date_intake')
        //         ->get()]
        $status = PersonalInformation::with(['remarkable', 'sectorName', 'assistance', 'municipal', 'chargingOffice'])
                ->whereNull('deleted_at')
                ->orderByDesc('date_intake')
                ->get();


        return inertia('Dashboard', [
            'totalNums' => $totalAssistance,
            'totalAmt' => $parseTotalAmt,
            'monitorings' => $monitorData,
            'monitorStatus' => $status,
            'sectorAvg' => $sumOfSectors,
        ]);
    }

    // Display the data in municipal chart when it selected
    public function getMunicipalityData(Request $request)
    {
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
    }

    // Display the data in assistance chart when it selected
    public function getAssistanceData(Request $request)
    {
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
    }


    // Display the data in sector chart when it selected
    public function getSectorData(Request $request)
    {
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
    }

}
