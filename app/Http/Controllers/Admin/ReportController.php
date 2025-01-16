<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sectoral;
use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    protected $currentYear;

    public function __construct($currentYear = null)
    {
        $this->currentYear = $currentYear ?? Carbon::now()->year;
    }

    /**
     * Chart Report of Intake Sheets & COE Served
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

        return inertia('Reports/IntakeSheetsServed', ['intakes' => $monthlyTotals, 'currentYear' => $this->currentYear]);
    }


    /**
     * Chart Report Per Municipality of Sectoral Data Module
     */
    public function perMunicipality()
    {
        $data = Sectoral::selectRaw('municipality as municipal, COUNT(*) as total')
                        ->groupBy('municipal')
                        ->orderBy('municipal')
                        ->get();

        $totalMun = [];

        $municipalities = [
            1 => 'Barobo',
            2 => 'Bayabas',
            3 =>'Bislig City',
            4 => 'Cagwait',
            5 => 'Cantilan',
            6 => 'Carmen',
            7 => 'Carrascal',
            8 => 'Cortes',
            9 => 'Hinatuan',
            10 => 'Lanuza',
            11 => 'Lianga',
            12 => 'Lingig',
            13 => 'Madrid',
            14 => 'Marihatag',
            15 => 'San Agustin',
            16 => 'San Miguel',
            17 => 'Tagbina',
            18 => 'Tago',
            19 => 'Tandag City'
        ];

        // Populate the municipality totals array
        foreach ($data as $mun) {
            $totalMun[$municipalities[$mun->municipal]] = $mun->total;
        }

        return inertia('Reports/PerMunicipality', ['totalMunicipal' => $totalMun, 'currentYear' => $this->currentYear]);
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
