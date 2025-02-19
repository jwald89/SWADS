<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Month;
use App\Models\User;
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
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BarangayResource;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\IndigentResource;
use App\Http\Resources\MunicipalityResource;
use App\Http\Resources\OfficeResource;
use App\Http\Resources\SectorResource;
use App\Models\IndigentPeople;
use App\Models\Office;
use App\Models\Sector;
use Database\Seeders\OfficeChargeSeeder;

class IntakeController extends Controller
{
    /**
     *  Personal Information data table display
     */
    public function index()
    {
        $perInfos = PersonalInformation::with(['assistance', 'municipal', 'brgy'])
                    ->when(request()->search !== '', function ($query) {
                        $search = request()->search;
                        $query->where(function ($subQuery) use ($search) {
                             $subQuery->where('sex', $search)
                            ->orWhere(function ($innerQuery) use ($search) {
                                // Broader search conditions
                                $innerQuery->where('first_name', 'like', '%' . $search . '%')
                                    ->orWhere('middle_name', 'like', '%' . $search . '%')
                                    ->orWhere('last_name', 'like', '%' . $search . '%')
                                    ->orWhereRaw("CONCAT(first_name, ' ', middle_name) like ?", ['%' . $search . '%'])
                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $search . '%'])
                                    ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) like ?", ['%' . $search . '%']);
                            });
                        });
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        $famComps = FamilyComposition::get();
        $assistance = AssistanceResource::collection(AssistanceType::all());
        $municipalName = MunicipalityResource::collection(Municipality::all());

        return inertia('IntakeIndex', [
            'intake' => $perInfos,
            'search' => request()->search ?? '',
            'famComps' => $famComps,
            'assistance' => $assistance,
            'months' => Month::names(),
            'municipalName' => $municipalName
        ]);
    }

    /**
     *  Personal Information form display
     */
    public function create()
    {
        $assistances = AssistanceResource::collection(AssistanceType::all());
        $sectorType = SectorResource::collection(Sector::all());
        $barangays = BarangayResource::collection(Barangay::all());
        $municipality = MunicipalityResource::collection(Municipality::all());
        $indigents = IndigentResource::collection(IndigentPeople::all());
        $officeCharge = OfficeResource::collection(Office::all());

        return inertia('IntakeCreate', [
            'assistances' => $assistances,
            'sectorType' => $sectorType,
            'barangays' => $barangays,
            'municipality' => $municipality,
            'indigents' => $indigents,
            'officeCharge' => $officeCharge,
            'civilStatus' => CivilStatus::names(),
            'gender' => GenderTypes::names(),
        ]);
    }

    /**
     *  Personal Information store process
     */
    public function storeP1(IntakeRequest $request)
    {
        $userId = Auth::id();
        // $personalInformation = PersonalInformation::create($request->all());
        $personalInformation = PersonalInformation::create(
            array_merge($request->all(), ['created_by' => $userId])
        );

        return response()->json($personalInformation, 201);
    }

    /**
     *  Family Compositions store process
     */
    public function storeP2(Request $request)
    {
        $request->validate([
            '*.firstname' => 'required|string|max:255',
            '*.lastname' => 'required|string|max:255',
            '*.middlename' => 'required|string|max:255',
            '*.age' => 'required',
            '*.relationship' => 'required|string|max:255',
            '*.educ_attainment' => 'required|string|max:255',
            '*.remarks' => 'required|string|max:255',
        ]);

        $userId = Auth::id();
        // $famComps = array_map(fn ($r) => FamilyComposition::create($r), $request->all());
        foreach ($request->all() as $familyComposition) {
            $familyComposition['created_by'] = $userId;
            $famComps[] = FamilyComposition::create($familyComposition);
        }

        return response()->json($famComps, 201);
    }

    /**
     * Family Compositions null store process
     */
    public function storeP2Null(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'applicant_id' => 'required',
            'lastname' => 'nullable',
            'firstname' => 'nullable',
            'middlename' => 'nullable',
            'age' => 'nullable|integer',
            'relationship' => 'nullable',
            'educ_attainment' => 'nullable',
            'remarks' => 'nullable',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Create a new FamilyComposition entry
        $famComps = FamilyComposition::create(
            array_merge($validatedData, ['created_by' => $userId])
        );

        // Return a JSON response with the created entry
        return response()->json([
            'success' => true,
            'data' => $famComps,
        ], 201);
    }

    /**
     *  Referrals store process
     */
    public function storeP3(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $userId = Auth::id();
        $referrals = Referral::create(
            array_merge($request->all(), ['created_by' => $userId])
        );

        return response()->json([
            'message' => 'You have successfully created!',
            'referrals' => $referrals,
        ]);
    }

    /**
     *  Remarks store process
     */
    public function storeP4(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $userId = Auth::id();
        $remarks = Remark::create(
            array_merge($request->all(), ['created_by' => $userId])
        );

        return response()->json([
            'message' => "You have successfully created!",
            'remarks' => $remarks,
        ]);
    }

    /**
     *  Personal Information show the detail process
     */
    public function show($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark', 'assistance', 'brgy', 'municipal'])->find($id);

        return inertia('ShowIntake', [
            'intakes' => $intakes
        ]);
    }

    /**
     * Intake Sheet edit process
     */
    public function edit($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark', 'brgy', 'municipal', 'sectorName', 'chargingOffice', 'indigent'])->find($id);

        $assistances = AssistanceResource::collection(AssistanceType::all());
        $sectorType = SectorResource::collection(Sector::all());
        $officeCharge = OfficeResource::collection(Office::all());
        $assistances = AssistanceResource::collection(AssistanceType::all());
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());
        $indigents = IndigentResource::collection(IndigentPeople::all());

        return inertia('EditIntake', [
            'intakes' => $intakes,
            'assistances' => $assistances,
            'sectorType' => $sectorType,
            'officeCharge' => $officeCharge,
            'indigents' => $indigents,
            'barangays' => $barangays,
            'municipality' => $municipality,
        ]);
    }

    /**
     *  Printing process
     */
    public function intakeSheetPrint($id)
    {
        $intakes = PersonalInformation::with(['assistance', 'user', 'brgy', 'municipal'])
                    ->where('id', $id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        $intakeCreatedId = PersonalInformation::with(['user'])->find($id);

        $createdBy = '';

         // Retrieve the created_by user details
         $createdByUser = null;
         if ($intakeCreatedId && $intakeCreatedId->created_by !== null) {
             $createdByUser = User::find($intakeCreatedId->created_by);
         }

         if ($createdByUser) {
            $createdBy = strtoupper($createdByUser->first_name) . ' '
                . strtoupper(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                . strtoupper($createdByUser->last_name);
        }

        $famCompose = DB::table('family_compositions')
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

        $pdf->loadView('intakes-sheet-print', compact('intakes', 'famCompose', 'referrals', 'remarks', 'createdBy'))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }

    /**
     * Print certificate of eligibility
     */
    public function coePrint($id)
    {
        $intakes = PersonalInformation::with(['assistance', 'user', 'brgy', 'municipal'])
                    ->where('id', $id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        $intakeCreatedId = PersonalInformation::with(['user'])->find($id);

        $createdBy = '';

        // Retrieve the created_by user details
        $createdByUser = null;
        if ($intakeCreatedId && $intakeCreatedId->created_by !== null) {
            $createdByUser = User::find($intakeCreatedId->created_by);
        }

        if ($createdByUser) {
            $createdBy = ucfirst($createdByUser->first_name) . ' '
            . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
            . ucfirst($createdByUser->last_name);
        }


        $pdf = App::make('snappy.pdf.wrapper');

        $pdf->loadView('coe-print', compact('intakes', 'createdBy'))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }


    /**
     *  Exporting process in ms excel
     */
    public function export($id)
    {
        $intakes = PersonalInformation::with(['assistance', 'brgy', 'municipal'])->findOrFail($id);

        $createdBy = '';

         // Retrieve the created_by user details
         $createdByUser = null;
         if ($intakes && $intakes->created_by !== null) {
             $createdByUser = User::find($intakes->created_by);
         }

         if ($createdByUser) {
            $createdBy = ucfirst($createdByUser->first_name) . ' '
                . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($createdByUser->last_name);
        }

        $templateProcessor = new TemplateProcessor('word-template/intake-sheet.docx');
        $templateProcessor->setValue('first_name', strtoupper($intakes?->first_name ?? ''));
        $templateProcessor->setValue('middle_name', strtoupper(substr($intakes?->middle_name ?? '', 0, 1)));
        $templateProcessor->setValue('last_name', strtoupper($intakes?->last_name ?? ''));
        $templateProcessor->setValue('nick_name', strtoupper($intakes?->nick_name ?? ''));
        $templateProcessor->setValue('date_intake', \Carbon\Carbon::parse($intakes?->date_intake ?? '')->format('j F Y'));
        $templateProcessor->setValue('category', ucwords($intakes?->assistance->name ?? ''));
        $templateProcessor->setValue('age', $intakes?->age ?? '');
        $templateProcessor->setValue('sex', ucwords($intakes?->sex ?? ''));
        $templateProcessor->setValue('civil_stats', ucwords($intakes?->civil_stats ?? ''));
        $templateProcessor->setValue('barangay', $intakes?->brgy->barangay ?? '');
        $templateProcessor->setValue('municipality', $intakes?->municipal->municipality ?? '');
        $templateProcessor->setValue('birthdate', \Carbon\Carbon::parse($intakes?->birthdate ?? '')->format('F j, Y'));
        $templateProcessor->setValue('job', $intakes?->job ?? '');
        $templateProcessor->setValue('income', $intakes?->income ?? '');
        $templateProcessor->setValue('contact_no', $intakes->contact_no ?? '');
        $templateProcessor->setValue('created_by', strtoupper($createdBy ?? ''));

        $families = FamilyComposition::where('applicant_id', $id)->get();
        $templateProcessor->cloneRow('firstname', $families->count());

        foreach ($families as $index => $family) {
            $rowIndex = $index + 1;
            $templateProcessor->setValue('firstname#' . $rowIndex, $family?->firstname ?? '');
            $templateProcessor->setValue('middlename#' . $rowIndex, substr($family?->middlename ?? '', 0, 1));
            $templateProcessor->setValue('lastname#' . $rowIndex, $family?->lastname ?? '');
            $templateProcessor->setValue('ageNo#' . $rowIndex, $family?->age ? $family?->age . " years old" : '');
            $templateProcessor->setValue('relationship#' . $rowIndex, $family?->relationship ?? '');
            $templateProcessor->setValue('educ_attainment#' . $rowIndex, $family?->educ_attainment ?? '');
            $templateProcessor->setValue('remarks#' . $rowIndex, $family?->remarks ?? '');
        }

        $referral = Referral::where('applicant_id', $id)->first();
        $templateProcessor->setValue('content', ucwords($referral?->content ?? ''));

        $remarks = Remark::where('applicant_id', $id)->first();
        $templateProcessor->setValue('remark', ucwords($remarks?->content ?? ''));

        $fileName = $intakes->last_name;
        $templateProcessor->saveAs($fileName. '.docx');

        return response()->download($fileName.'.docx')->deleteFileAfterSend(true);
    }

    /**
     *  Update Intake Sheets
     */
    public function update(Request $request, $id)
    {
        return DB::transaction(function() use($id, $request) {
            $personalData = PersonalInformation::findOrFail($id);
            $personalData->update($request->except('family_compositions'));

            foreach($request->fam_compose as $familyCompose) {
                $family = FamilyComposition::find($familyCompose['id']);
                $family['lastname'] = $familyCompose['lastname'];
                $family['firstname'] = $familyCompose['firstname'];
                $family['middlename'] = $familyCompose['middlename'];
                $family['age'] = $familyCompose['age'];
                $family['relationship'] = $familyCompose['relationship'];
                $family['educ_attainment'] = $familyCompose['educ_attainment'];
                $family['remarks'] = $familyCompose['remarks'];
                $family->save();
            }

            foreach ($request->referral as $referralData) {
                $referral = Referral::find($referralData['id']);
                $referral['content'] = $referralData['content'];
                $referral->save();
            }

            foreach ($request->remark as $remarkData) {
                $remark = Remark::find($remarkData['id']);
                $remark['content'] = $remarkData['content'];
                $remark->save();
            }

            return response()->json([
                'personal_data' => $personalData,
                'family_compositions' => $personalData->fam_compose,
                'referral' => $personalData->referral,
                'remark' => $personalData->remark,
            ]);
        });
    }


    /**
     * Delete the data when it's discarded
     */
    public function deleteRecords(Request $request)
    {
        // validate id key
        return DB::transaction(function () use($request) {
            $data = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($request->id);
            $data->delete();
            $data->famCompose()?->delete();
            $data->referral()?->delete();
            $data->remark()?->delete();

            return response()->json(['success' => true], 200);
        });
    }


    /**
     * Filter the specified assistance, municipality, month and year
     */
    public function filter($assistanceId = '*', $municipalId = '*', $month = '*')
    {
        $data = PersonalInformation::with(['assistance', 'municipal', 'brgy']);

        if ($assistanceId !== '*') {
            $data->where('category', $assistanceId);
        }

        if ($municipalId !== '*') {
            $data->where('municipality', $municipalId);
        }

        if ($month !== '*') {
            $data->whereMonth('date_intake', $month);
        }

        return response()->json($data->get());
    }


    /**
     * Not is use
     */
    // public function destroy($id)
    // {
    //     $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

    //     $intakes->delete();

    //     return response()->json(['success' => true]);
    // }
}
