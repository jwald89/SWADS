<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Sector;
use App\Models\Barangay;
use App\Models\Medicine;
use App\Utility\Formatter;
use App\Models\Municipality;
use App\Models\Classification;
use App\Models\IndigentPeople;
use App\Models\FamRelationship;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MedicineRequest;
use App\Http\Resources\SectorResource;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\IndigentResource;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Resources\MunicipalityResource;
use App\Http\Resources\ClassificationResource;
use App\Http\Resources\FamRelationshipResource;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::with(['sectorName', 'barangay', 'municipal', 'user'])
                    ->when(request()->search !== '', function($query) {
                        $search = request()->search;
                            $query->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('middle_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhereRaw("CONCAT(first_name, ' ', middle_name) like ?", ['%' . $search . '%'])
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $search . '%'])
                                ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) like ?", ['%' . $search . '%']);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        $sectors = SectorResource::collection(Sector::all());
        $barangays = BarangayResource::collection(Barangay::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());

        return inertia('MedicineIndex', [
            'search' => request()->search ?? '',
            'sectors' => $sectors,
            'medicine' => $medicines,
            'barangays' => $barangays,
            'municipalities' => $municipalities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangays = BarangayResource::collection(Barangay::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());
        $famRelationships = FamRelationshipResource::collection(FamRelationship::all());
        $sectorType = SectorResource::collection(Sector::all());
        $classType = ClassificationResource::collection(Classification::all());
        $indigents = IndigentResource::collection(IndigentPeople::all());

        return inertia('MedicineCreate', [
            'sectorType' => $sectorType,
            'classType' => $classType,
            'indigents' => $indigents,
            'barangays' => $barangays,
            'municipalities' => $municipalities,
            'famRelationships' => $famRelationships,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineRequest $request)
    {
        $userId = Auth::id();

        $medicine = Medicine::create(
            array_merge($request->all(), [
                'created_by' => $userId,
                'amount' => str_replace(',', '', $request->input('amount', $request->amount))
            ])
        );

        return response()->json($medicine, 201);
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
        $medicines = Medicine::with(['barangay', 'municipal', 'famRelation'])->find($id);

        $barangays = BarangayResource::collection(Barangay::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());
        $famRelationships = FamRelationshipResource::collection(FamRelationship::all());
        $sectorType = SectorResource::collection(Sector::all());
        $classType = ClassificationResource::collection(Classification::all());
        $indigents = IndigentResource::collection(IndigentPeople::all());

        return inertia('MedicineEdit', [
            'sectorType' => $sectorType,
            'classType' => $classType,
            'indigents' => $indigents,
            'medicines' => $medicines,
            'barangays' => $barangays,
            'municipalities' => $municipalities,
            'famRelationships' => $famRelationships,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineRequest $request, string $id)
    {
        $medicine = Medicine::findOrFail($id);

        $medicine->update(array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now(),
                'amount' => str_replace(',', '', $request->input('amount', $medicine->amount))
            ])
        );

        return response()->json($medicine, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Print view of guarante letter.
     */
    public function printGuarantLetter(string $id)
    {
        $medicines = Medicine::with(['barangay', 'municipal', 'user', 'famRelation', 'sectorName'])
                    ->where('id', $id)
                    ->get();

        $intakeCreatedId = Medicine::with(['user'])->find($id);

        $createdBy = '';

         $createdByUser = null;
         if ($intakeCreatedId && $intakeCreatedId->created_by !== null) {
             $createdByUser = User::find($intakeCreatedId->created_by);
         }

         if ($createdByUser) {
            $createdBy = strtoupper($createdByUser->first_name) . ' '
                . ($createdByUser->middle_init === null ? "" : strtoupper(substr($createdByUser->middle_init, 0, 1)) . '. ')
                . strtoupper($createdByUser->last_name);
        }

        $pdf = App::make('snappy.pdf.wrapper');

        $pdf->loadView('guarante-letter-print', compact('medicines', 'createdBy'))
            ->setPaper('legal')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 8)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }

    /**
     * Print view of assistance slip.
     */
    public function printAssistantSlip(string $id)
    {
        $medicines = Medicine::with(['barangay', 'municipal', 'user', 'famRelation'])
                    ->where('id', $id)
                    ->get();

        $intakeCreatedId = Medicine::with(['user'])->find($id);
        $createdBy = '';

         $createdByUser = null;
         if ($intakeCreatedId && $intakeCreatedId->created_by !== null) {
             $createdByUser = User::find($intakeCreatedId->created_by);
         }

         if ($createdByUser) {
            $createdBy = strtoupper($createdByUser->first_name) . ' '
                . ($createdByUser->middle_init === null ? "" : strtoupper(substr($createdByUser->middle_init, 0, 1)) . '. ')
                . strtoupper($createdByUser->last_name);
        }

        $pdf = App::make('snappy.pdf.wrapper');

        $pdf->loadView('assistance-slip-print', compact('medicines', 'createdBy'))
            ->setPaper('letter')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 20)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }

    public function export($id)
    {
        $medicines = Medicine::with(['barangay', 'municipal', 'famRelation', 'sectorName'])->findOrFail($id);

        $createdBy = '';
        $userDesignation = '';

        $createdByUser = null;
        $byDesignation = null;
        if ($medicines && $medicines->created_by !== null) {
            $createdByUser = User::find($medicines->created_by);
        }

        if ($createdByUser) {
            $createdBy = strtoupper($createdByUser->first_name) . ' '
                . ($createdByUser->middle_init === null ? "" : strtoupper(substr($createdByUser->middle_init, 0, 1)) . ". ")
                . strtoupper($createdByUser->last_name);
        }

        if ($medicines && $medicines->created_by !== null) {
            $byDesignation = User::find($medicines->created_by);
        }

        if ($byDesignation) {
            $userDesignation = $byDesignation->title;
        }

        $formatter = new Formatter;

        $templateProcessor = new TemplateProcessor('word-template/medicine-sheet.docx');
        $templateProcessor->setValue('date_started', Carbon::parse($medicines?->date_started)->format('F j, Y') ?? '');
        $templateProcessor->setValue('date_ended', Carbon::parse($medicines?->date_ended)->format('F j, Y') ?? '');
        $templateProcessor->setValue('sector_type', $medicines?->sectorName->name ?? '');
        $templateProcessor->setValue('first_name', strtoupper($medicines?->first_name) ?? '');
        $templateProcessor->setValue('middle_name', strtoupper(substr($medicines?->middle_name, 0, 1)) .'.' ?? '');
        $templateProcessor->setValue('last_name', strtoupper($medicines?->last_name) ?? '');
        $templateProcessor->setValue('suffix', strtoupper($medicines?->suffix) ?? '');
        $templateProcessor->setValue('brgy', $medicines?->barangay->barangay ?? '');
        $templateProcessor->setValue('municipality', $medicines?->municipal->municipality ?? '');
        $templateProcessor->setValue('amt', number_format($medicines?->amount, 2, '.', ',') ?? '');
        $templateProcessor->setValue('type_assistance', $medicines?->type_assistance ?? '');
        $templateProcessor->setValue('beneficiary', ucwords($medicines?->beneficiary) ?? '');
        $templateProcessor->setValue('relationship', $medicines?->famRelation->name ?? '');
        $templateProcessor->setValue('kinds_of_med', ucwords($medicines?->kinds_of_med) ?? '');
        $templateProcessor->setValue('problem_present', $medicines?->problem_present ?? '');
        $templateProcessor->setValue('assistance_need', $medicines?->assistance_need ?? '');
        $templateProcessor->setValue('created_by', strtoupper($createdBy) ?? '');
        $templateProcessor->setValue('amt_in_words', ucwords($formatter->amountInWords($medicines->amount)) ?? '');
        $templateProcessor->setValue('created_at', Carbon::parse($medicines?->created_at)->format('F j, Y') ?? '');
        $templateProcessor->setValue('designation', strtoupper($userDesignation) ?? '');

        $fileName = $medicines->last_name;
        $templateProcessor->saveAs($fileName. '.docx');

        return response()->download($fileName.'.docx')->deleteFileAfterSend(true);
    }


    public function filter($sectorId = '*', $municipalId = '*', $month = '*')
    {
        $data = Medicine::with(['sectorName', 'barangay', 'municipal', 'user']);

        if ($municipalId !== '*') {
            $data->where('municipality', $municipalId);
        }

        if ($sectorId !== '*') {
            $data->where('sector_type', $sectorId);
        }

        if ($month !== '*') {
            $data->whereMonth('created_at', $month);
        }

        $paginatedData = $data->orderBy('created_at', 'DESC')->paginate(10);

        if ($paginatedData->isEmpty()) {
            return response()->json(['message' => 'No data found']);
        }

        return $paginatedData;
    }
}
