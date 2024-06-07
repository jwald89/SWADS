<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barangay;
use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\AssistanceType;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\IntakeRequest;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\MunicipalityResource;
use App\Models\FamilyComposition;

class IntakeController extends Controller
{
    public function index()
    {
        $perInfos = PersonalInformation::get();
        $famComps = FamilyComposition::get();

        return inertia('IntakeIndex', [
            'perInfos' => $perInfos,
            'famComps' => $famComps
        ]);
    }

    public function create()
    {
        $assistances = AssistanceResource::collection(AssistanceType::all());
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());

        return inertia('IntakeCreate', [
            'barangays' => $barangays,
            'assistances' => $assistances,
            'municipality' => $municipality,
            'civilStatus' => CivilStatus::names(),
            'gender' => GenderTypes::names(),
        ]);
    }

    public function storeP1(IntakeRequest $request)
    {
        $personalInformation = PersonalInformation::create($request->all());

        // Convert the personal_information record to JSON
        $personalInformationJson = $personalInformation->toJson();

        return response()->json([
            'message' => 'Personal information created successfully.',
            'data' => json_decode($personalInformationJson, true),
        ]);
    }


    public function storeP2(Request $request)
    {
        $famComps = FamilyComposition::create($request->all());

        $famCompJson = $famComps->toJson();

        return response()->json([
            'message' => 'Personal information created successfully.',
            'data' => json_decode($famCompJson, true),
        ]);
    }
}
