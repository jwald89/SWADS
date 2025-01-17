<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sectoral;
use App\Models\Monitoring;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Models\AssistanceType;

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
     * Chart Report AICS Per Municipality of Sectoral Data Module
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


    /**
     * Chart Report AICS Served Per Sectoral Group
     */
    public function servedPerSectoral()
    {
        $getSector = Sectoral::selectRaw('sector as sec, COUNT(*) as total')
                        ->groupBy('sec')
                        ->orderBy('sec')
                        ->get();

        $totalSectors = [];

        $sectors = [
            1 => 'Mens',
            2 => 'Womens',
            3 => 'Youth',
            4 => 'Children',
            5 => 'Senior Citizen',
            6 => 'PWD',
            7 => 'Solo Parent',
            8 => 'Former Rebel',
        ];


        // Populate the sector data totals array
        foreach ($getSector as $data) {
            $totalSectors[$sectors[$data->sec]] = $data->total;
        }

        return inertia('Reports/ServedPerSectoral' , ['totalSectors' => $totalSectors, 'currentYear' => $this->currentYear]);
    }

    public function perSectoral()
    {
        $assistanceType = Monitoring::selectRaw('assistance_type as assistance, COUNT(*) as total')
                    ->groupBy('assistance')
                    ->orderBy('assistance')
                    ->get();

        $totalAssist = [];

        $types = [
            1 => 'Medical',
            2 => 'Burial',
            3 => 'Educational',
            4 => 'Financial',
            5 => 'Livelihood',
            6 => 'Transportation',
            7 => 'Financial/ Solo Parent',
            8 => 'Financial/ Mentally ill',
            9 => 'Financial/ Special Case',
            10 => 'Financial/ Repatriated',
            11 => 'Financial/ VAWC',
        ];

         // Populate the assistance_type data totals array
        foreach ($assistanceType as $data) {
            $totalAssist[$types[$data->assistance]] = $data->total;
        }

        return inertia('Reports/PerSectoral', ['totalAssistance' => $totalAssist, 'currentYear' => $this->currentYear, $this->currentYear]);
    }

}
