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
use Illuminate\Support\Facades\DB;
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

        if (Auth::user()->role_type === 'ADMIN' || Auth::user()->role_type === 'USER' || Auth::user()->role_type === 'MUNICIPAL')
        {
            $data = Sectoral::with('sector','municipality')->when(Auth::user()->role_type === 'MUNICIPAL', function ($query) {
                $query->where('municipality', '=', Auth::user()->mun_id);
            })->get();
        }

        $municipalities = MunicipalityResource::collection(Municipality::all());
        $sectors = SectorResource::collection(Sector::all());

        return inertia('SectoralDataIndex', [
            'municipalities' => $municipalities,
            'sectors' => $sectors,
            'months' => Month::names(),
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());
        $sectors = SectorResource::collection(Sector::all());

        return inertia('CreateSectoral', [
            'municipality' => $municipality,
            'barangays' => $barangays,
            'civilStatus' => CivilStatus::names(),
            'gender' => GenderTypes::names(),
            'sectors' => $sectors,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectoralDataRequest $request)
    {
        $userId = Auth::id();

        $sectoralData = Sectoral::create(
            array_merge($request->all(), ['created_by' => $userId])
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
    public function edit($id)
    {
        $sectoral = Sectoral::findOrFail($id);
        $sectors = SectorResource::collection(Sector::all());
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());

        return inertia('EditSectoral', [
            'sectoral' => $sectoral,
            'sectors' => $sectors,
            'municipality' => $municipality,
            'barangays' => $barangays
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sectoral = Sectoral::findOrFail($id);

        $sectoral->update($request->all());

        return $sectoral;
    }


    /**
     * Filter the specified sector, municipality, month and year
     */
    public function filter($sector = '*', $municipality = '*')
    {
        $data = DB::table('sectorals')->select('id', 'sector', 'first_name', 'middle_name', 'last_name', 'age', 'birthdate', 'municipality', 'date_encoded');

        if ($sector !== '*') {
            $data->where('sector', $sector);
        }

        if ($municipality !== '*') {
            $data->where('municipality', $municipality);
        }

         // Return the results as a JSON response
         return response()->json($data->get());
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
