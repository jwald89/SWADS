<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function intakeSheetServed()
    {
        // Get the sum of transactions grouped by month
        $intakes = PersonalInformation::selectRaw('MONTH(date_intake) as month, COUNT(*) as total')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();

        // Create an array to hold the results in a month-name format
        $monthlyTotals = [];

        // Map month numbers to names
        $monthNames = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];

        // Populate the monthly totals array
        foreach ($intakes as $intake) {
            $monthlyTotals[$monthNames[$intake->month]] = $intake->total;
        }

        return inertia('Reports/IntakeSheetsServed', ['intakes' => $monthlyTotals]);
    }


    public function perMunicipality()
    {
        return inertia('Reports/PerMunicipality');
    }


    public function servedPerSectoral()
    {
        return inertia('Reports/ServedPerSectoral');
    }

    public function perSectoral()
    {
        return inertia('Reports/PerSectoral');
    }

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
