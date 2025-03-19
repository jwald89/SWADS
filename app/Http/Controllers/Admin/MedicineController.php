<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Month;
use App\Models\Barangay;
use App\Models\Medicine;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\FamRelationship;
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
        $medicines = Medicine::with(['brgy', 'municipal', 'user'])->get();

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
}
