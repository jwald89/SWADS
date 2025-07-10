<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Office;
use App\Models\Sector;
use App\Models\Monitoring;
use App\Models\Municipality;
use App\Models\AssistanceType;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfficeResource;
use App\Http\Resources\SectorResource;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\MunicipalityResource;
use App\Models\PersonalInformation;

class SummaryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $monitorings = Monitoring::with(['intake', 'assistance', 'sectorName', 'municipal', 'chargingOffice'])->get();
        $intakes = PersonalInformation::with(['remark', 'assistance', 'sectorName', 'municipal', 'chargingOffice'])->get();

        $assistance = AssistanceResource::collection(AssistanceType::all());
        $sectorType = SectorResource::collection(Sector::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());
        $offCharges = OfficeResource::collection(Office::all());

        return inertia('Reports/SummaryReport', [
                        'intakes' => $intakes,
                        'assistanceType' => $assistance,
                        'sectorType' => $sectorType,
                        'municipalities' => $municipalities,
                        'offCharges' => $offCharges,
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function filter($assistanceId = '*', $sectorId = '*', $municipalId = '*', $officeId = '*', $dateFrom = null, $dateTo = null)
    {
        // $query = Monitoring::with(['intake', 'assistance', 'sectorName', 'municipal', 'chargingOffice']);
        $query = PersonalInformation::with(['assistance', 'sectorName', 'municipal', 'chargingOffice']);

        $printFrom = Carbon::parse($dateFrom)->format('Y-m-d');
        $printTo = Carbon::parse($dateTo)->format('Y-m-d');

        if ($assistanceId !== "*") {
            // $query->where('assistance_type', $assistanceId);
            $query->where('category', $assistanceId);
        }
        if ($sectorId !== '*') {
            // $query->where('sector', $sectorId);
            $query->where('sector_type', $sectorId);
        }
        if ($municipalId !== '*') {
            $query->where('municipality', $municipalId);
        }
        if ($officeId !== '*') {
            // $query->where('charges', $officeId);
            $query->where('ofis_charge', $officeId);
        }

        // Apply date range filter //
        $query->whereBetween('date_intake', [$printFrom, $printTo]);

        // Get filtered results //
        $summary = $query->orderBy('date_intake', 'asc')->get();
        // $totalAmt = $query->sum('amount');

        // Generate PDF //
        $pdf = App::make('snappy.pdf.wrapper');
        // $pdf->loadView('summary-report', compact('summary', 'totalAmt', 'printFrom', 'printTo'))
        $pdf->loadView('summary-report', compact('summary', 'printFrom', 'printTo'))
            ->setPaper('legal')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('landscape');

        return $pdf->inline();
    }


}
