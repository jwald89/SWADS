<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Remark;
use App\Models\Barangay;
use App\Models\Referral;
use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\AssistanceType;
use App\Models\FamilyComposition;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\App;
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

    public function edit($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        return inertia('EditIntake', [
            'intakes' => $intakes
        ]);
    }

    // Personal Information store process
    public function editP1($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        return inertia('EditIntake', [
            'intakes' => $intakes
        ]);
    }

    // Family Compositions store process
    public function editP2($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        return inertia('EditIntake', [
            'intakes' => $intakes
        ]);
    }

    // Referrals store process
    public function editP3($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        return inertia('EditIntake', [
            'intakes' => $intakes
        ]);
    }

    // Remarks store process
    public function editP4($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        return inertia('EditIntake', [
            'intakes' => $intakes
        ]);
    }

    public function print($id)
    {
        $intakes = DB::table('personal_information')
            ->select('id', 'classification', 'category', 'date_intake', 'first_name', 'middle_name', 'last_name', 'nick_name', 'extn_name', 'age', 'birthdate', 'sex', 'purok', 'street', 'barangay', 'municipality', 'civil_stats', 'job', 'contact_no', 'income')
            ->where('id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $famCompose = DB::table('family_compositions')
            // ->leftJoin('personal_information', 'family_compositions.applicant_id', '=', 'personal_information.id')
            ->select('id', 'lastname', 'firstname', 'middlename', 'age', 'relationship', 'educ_attainment', 'remarks')
            ->where('applicant_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $referrals = DB::table('referrals')
            ->select('id', 'content')
            ->where('applicant_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $remarks = DB::table('remarks')
            ->select('id', 'content')
            ->where('applicant_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = App::make('snappy.pdf.wrapper');

        $pdf->loadView('intakes-sheet', compact('intakes', 'famCompose', 'referrals', 'remarks'))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }
}
