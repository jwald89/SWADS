<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Month;
use App\Models\User;
use App\Models\Barangay;
use App\Models\Medicine;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\FamRelationship;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MedicineRequest;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\MunicipalityResource;
use App\Http\Resources\FamRelationshipResource;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::with(['barangay', 'municipal', 'user'])->get();

        $barangays = BarangayResource::collection(Barangay::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());

        return inertia('MedicineIndex', [
            'medicines' => $medicines,
            'barangays' => $barangays,
            'municipalities' => $municipalities,
            'months' => Month::names(),
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

        return inertia('MedicineCreate', [
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
            array_merge($request->all(), ['created_by' => $userId])
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

    /**
     * Print view of guarante letter.
     */
    public function printGuarantLetter(string $id)
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

        $pdf->loadView('guarante-letter-print', compact('medicines', 'createdBy'))
            ->setPaper('letter')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 0);
            // ->setOption('viewport-size', '1280x1024')
            // ->setOption('dpi', 96);

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

        $pdf->loadView('assistance-slip-print', compact('medicines'))
            ->setPaper('letter')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 20)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }
}
