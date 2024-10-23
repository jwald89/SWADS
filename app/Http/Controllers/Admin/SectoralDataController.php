<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Month;
use App\Models\Sector;
use App\Models\Barangay;
use App\Models\Sectoral;
use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SectorResource;
use App\Http\Resources\BarangayResource;
use App\Http\Requests\SectoralDataRequest;
use App\Http\Resources\MunicipalityResource;

class SectoralDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municipalities = MunicipalityResource::collection(Municipality::all());
        $sectors = SectorResource::collection(Sector::all());

        return inertia('SectoralDataIndex', [
            'municipalities' => $municipalities,
            'sectors' => $sectors,
            'months' => Month::names(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());

        return inertia('CreateSectoral', [
            'municipality' => $municipality,
            'barangays' => $barangays,
            'civilStatus' => CivilStatus::names(),
            'gender' => GenderTypes::names(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectoralDataRequest $request)
    {
        $userId = Auth::id();

        $sectoralData = Sectoral::create(
            array_merge($request->all(), ['user_id' => $userId])
        );

        return response()->json($sectoralData, 201);
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
