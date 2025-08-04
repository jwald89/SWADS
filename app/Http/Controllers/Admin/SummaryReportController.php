<?php

namespace App\Http\Controllers\Admin;

use Log;
use Carbon\Carbon;
use App\Models\Office;
use App\Models\Sector;
use App\Models\Medicine;
use App\Models\Municipality;
use App\Models\AssistanceType;
use App\Models\Classification;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfficeResource;
use App\Http\Resources\SectorResource;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\MunicipalityResource;
use App\Http\Resources\ClassificationResource;

class SummaryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function intakeIndex()
    {
        // $monitorings = Monitoring::with(['intake', 'assistance', 'sectorName', 'municipal', 'chargingOffice'])->get();
        $intakes = PersonalInformation::with(['remark', 'assistance', 'sectorName', 'municipal', 'chargingOffice'])->get();

        $assistance = AssistanceResource::collection(AssistanceType::all());
        $sectorType = SectorResource::collection(Sector::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());
        $offCharges = OfficeResource::collection(Office::all());

        return inertia('Reports/IntakeSummaryReport', [
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
    public function intakeFilter($assistanceId = '*', $sectorId = '*', $municipalId = '*', $officeId = '*', $dateFrom = null, $dateTo = null)
    {
        $query = PersonalInformation::with(['remark', 'remarkable', 'assistance', 'sectorName', 'municipal', 'chargingOffice']);

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
        $query->whereNull('deleted_at')->whereBetween('date_intake', [$printFrom, $printTo]);

        // Get the filtered results
        $summary = $query->get();

        // Initialize total amount
        $totalAmt = 0;

        // Sum the amounts
        foreach ($summary as $item) {
            // Ensure remarkable is loaded and not null
            if ($item->remark) {
                $data = $item->remark->sum('cash_assistance');
                $totalAmt += $data;
            }
        }

        // Generate PDF //
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('intake-summary-report', compact('summary', 'totalAmt', 'printFrom', 'printTo'))
        // $pdf->loadView('summary-report', compact('summary', 'printFrom', 'printTo'))
            ->setPaper('legal')
            ->setOption('footer-center', 'Page [page] of [toPage]')
            ->setOption('footer-font-size', 8)
            ->setOption('margin-bottom', 10)
            ->setOption('enable-local-file-access', true)
            ->setOrientation('landscape');

        return $pdf->inline();
    }


    public function medicineIndex()
    {
        $medicines = Medicine::with(['sectorName', 'barangay', 'municipal', 'user'])->get();

        $sectors = SectorResource::collection(Sector::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());
        $classType = ClassificationResource::collection(Classification::all());

        return inertia('Reports/MedicineSummaryReport', [
                        'medicines' => $medicines,
                        'sectorType' => $sectors,
                        'municipalities' => $municipalities,
                        'classType' => $classType
                    ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function medicineFilter($sectorId = '*', $municipalId = '*', $classTypeId = '*', $dateFrom = null, $dateTo = null)
    {
        $query = Medicine::with(['sectorName', 'barangay', 'municipal', 'user', 'classificationName']);

        $printFrom = Carbon::parse($dateFrom)->format('Y-m-d');
        $printTo = Carbon::parse($dateTo)->format('Y-m-d');


        if ($sectorId !== '*') {
            $query->where('sector_type', $sectorId);
        }
        if ($municipalId !== '*') {
            $query->where('municipality', $municipalId);
        }
        if ($classTypeId !== '*') {
            $query->where('ips', $classTypeId);
        }

        // Apply date range filter //
        $query->whereBetween('created_at', [$printFrom, $printTo]);

        // Get the filtered results
        $summary = $query->get();

        // Initialize total amount
        $totalAmt = 0;

        // Sum the amounts
        foreach ($summary as $item) {
            $totalAmt += $item->amount; // Use += to correctly accumulate the total
        }

        // Generate PDF //
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('medicine-summary-report', compact('summary', 'totalAmt', 'printFrom', 'printTo'))
            ->setPaper('legal')
            ->setOption('footer-center', 'Page [page] of [toPage]')
            ->setOption('footer-font-size', 8)
            ->setOption('margin-bottom', 10)
            ->setOption('enable-local-file-access', true)
            ->setOrientation('landscape');

        return $pdf->inline();
    }

}
