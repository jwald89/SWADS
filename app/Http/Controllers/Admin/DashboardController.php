<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sectoral;
use App\Models\Monitoring;
use Illuminate\Http\Request;
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
        $totalAmt = DB::table('monitorings')->sum('amount');
        $monitorData = Monitoring::with(['intake', 'assistance'])
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(3))
                    ->get();
        $totalSectors = Sectoral::count();
        $totalMonitors = Monitoring::count();
        $sumOfSectors = $totalMonitors + $totalSectors;

        $status = Monitoring::with(['intake', 'sector'])->get();

        return inertia('Dashboard', [
            'totalNums' => $totalAssistance,
            'totalAmt' => $totalAmt,
            'monitorings' => $monitorData,
            'monitorStatus' => $status,
            'sectorAvg' => $sumOfSectors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
