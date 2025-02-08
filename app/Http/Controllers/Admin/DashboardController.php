<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sectoral;
use App\Models\Monitoring;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalAssistance = DB::table('personal_information')->count();
        $totalAmt = DB::table('monitorings')->where('deleted_at', null)->sum('amount');
        $monitorData = Monitoring::with(['intake', 'assistance'])
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
                    ->get();
        $totalSectors = Sectoral::count();
        $totalMonitors = Monitoring::where('deleted_at', NULL)->count();
        $sumOfSectors = $totalMonitors + $totalSectors;

        $parseTotalAmt = number_format($totalAmt,2,".",",");

        $status = Monitoring::with(['intake', 'sector', 'assistance'])->get();

        return inertia('Dashboard', [
            'totalNums' => $totalAssistance,
            'totalAmt' => $parseTotalAmt,
            'monitorings' => $monitorData,
            'monitorStatus' => $status,
            'sectorAvg' => $sumOfSectors,
        ]);
    }


}
