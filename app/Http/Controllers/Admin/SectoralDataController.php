<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Enums\Month;
use App\Models\User;
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

        if (Auth::user()->role_type === 'ADMIN' || Auth::user()->role_type === 'USER' || Auth::user()->role_type === 'MUNICIPAL')
        {
            $sectoral = Sectoral::with(['sector', 'municipality'])
                ->when(request()->search !== '', function ($query) {
                    $search = request()->search;
                    $query->where(function ($query) use($search) {
                        $query->where('sector', 'like', '%' . $search . '%')
                            ->orWhere('first_name', 'like', '%' . $search . '%')
                            ->orWhere('middle_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhereRaw("CONCAT(first_name, ' ', middle_name) like ?", ['%' . $search . '%'])
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $search . '%'])
                            ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) like ?", ['%' . $search . '%']);
                    })->orWhereHas('sector', function($sector) use($search) {
                        $sector->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('municipality', function($municipalQuery) use($search) {
                        $municipalQuery->where('municipality', 'like', '%' . $search . '%');
                    });
                })
                ->when(Auth::user()->role_type === 'MUNICIPAL', function ($query) {
                        $query->where('municipality', '=', Auth::user()->municipality);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        $municipalities = MunicipalityResource::collection(Municipality::all());
        $sectors = SectorResource::collection(Sector::all());

        return inertia('SectoralDataIndex', [
            'municipalities' => $municipalities,
            'sectors' => $sectors,
            'months' => Month::names(),
            'sectoral' => $sectoral,
            'search' => request()->search ?? ''
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

        $sectoral->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return response()->json(['success' => true]);
    }


    /**
     * Filter the specified sector, municipality, month and year
     */
    public function filter($sector = '*', $municipality = '*')
    {
        $data = Sectoral::with(['municipality', 'sector']);

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
    public function destroy($id)
    {
        $sectoral = Sectoral::find($id);

        $sectoral->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sectoral = Sectoral::with(['user', 'barangay', 'municipality', 'sector'])->find($id);

        $createdBy = '';
        $modifiedBy = '';

        // Retrieve the created_by user details
        $createdByUser = null;
        if ($sectoral && $sectoral->created_by !== null) {
            $createdByUser = User::find($sectoral->created_by);
        }

        if ($createdByUser) {
            $createdBy = ucwords($createdByUser->first_name) . ' '
                . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($createdByUser->last_name);
        }

        // Retrieve the modified_by user details
        $modifiedByUser = null;
        if ($sectoral && $sectoral->modified_by !== null) {
            $modifiedByUser = User::find($sectoral->modified_by);
        }

        if ($modifiedByUser) {
            $modifiedBy = ucwords($modifiedByUser->first_name) . ' '
                . ucfirst(substr($modifiedByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($modifiedByUser->last_name);
        }

        return inertia('ShowSectoral', [
            'sectoral' => $sectoral,
            'createdBy' => $createdBy,
            'modifiedBy' => $modifiedBy
        ]);
    }

}
