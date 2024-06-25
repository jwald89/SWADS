<?php

namespace App\Http\Controllers\Admin;

use App\Models\Remark;
use App\Models\Barangay;
use App\Models\Referral;
use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\AssistanceType;
use App\Models\FamilyComposition;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\IntakeRequest;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\MunicipalityResource;

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

    // Personal Information store process
    public function storeP1(IntakeRequest $request)
    {
        $personalInformation = PersonalInformation::create($request->all());

        return response()->json($personalInformation, 201);
    }

    // Family Compositions store process
    public function storeP2(Request $request)
    {
        $famComps = FamilyComposition::create($request->all());

        // return response()->json([
        //     'message' => 'Personal information created successfully.',
        //     'data' => $famComps,
        // ]);
        return response()->json($famComps, 201);
    }

    // Referrals store process
    public function storeP3(Request $request)
    {
        $referrals = Referral::create($request->all());

        return response()->json([
            'message' => 'You have successfully created!',
            'referrals' => $referrals,
        ]);
    }

    // Remarks store process
    public function storeP4(Request $request)
    {
        $remarks = Remark::create($request->all());

        return response()->json([
            'message' => "You have successfully created!",
            'remarks' => $remarks,
        ]);
    }

    public function show($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        return inertia('ShowIntake', [
            'intakes' => $intakes
        ]);
    }
}
