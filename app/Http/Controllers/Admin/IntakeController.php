<?php

namespace App\Http\Controllers\Admin;

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
use App\Http\Resources\MunicipalityResource;

class IntakeController extends Controller
{
    // Personal Information data table display
    public function index()
    {
        $perInfos = PersonalInformation::with(['assistance'])
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
                        })->orWhereHas('assistance', function ($assistanceQuery) use ($search) {
                            $assistanceQuery->where('name', 'like', '%' . $search . '%');
                        });
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        $famComps = FamilyComposition::get();

        return inertia('IntakeIndex', [
            'intake' => $perInfos,
            'search' => request()->search ?? '',
            'famComps' => $famComps
        ]);
    }

    // Personal Information form display
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
        $userId = Auth::id();
        // $personalInformation = PersonalInformation::create($request->all());
        $personalInformation = PersonalInformation::create(
            array_merge($request->all(), ['created_by' => $userId])
        );

        return response()->json($personalInformation, 201);
    }

    // Family Compositions store process
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

    // Referrals store process
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

    // Remarks store process
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

    // Personal Information show the detail process
    public function show($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark', 'assistance'])->find($id);

        return inertia('ShowIntake', [
            'intakes' => $intakes
        ]);
    }

    // Intake Sheet edit process
    public function edit($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        $assistances = AssistanceResource::collection(AssistanceType::all());
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());

        return inertia('EditIntake', [
            'intakes' => $intakes,
            'assistances' => $assistances,
            'barangays' => $barangays,
            'municipality' => $municipality,
        ]);
    }


    public function destroy($id)
    {
        $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($id);

        $intakes->delete();

        return response()->json(['success' => true]);
    }


    // Printing process
    public function intakeSheetPrint($id)
    {
        $intakes = PersonalInformation::with(['assistance', 'user'])
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

        $pdf->loadView('intakes-sheet-print', compact('intakes', 'famCompose', 'referrals', 'remarks', 'createdBy'))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }

    // Print certificate of eligibility
    public function coePrint($id)
    {
        $intakes = PersonalInformation::with(['assistance', 'user'])
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


    // Exporting process
    public function export($id)
    {
        $intakes = PersonalInformation::with(['assistance'])->findOrFail($id);

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
        $templateProcessor->setValue('barangay', $intakes?->barangay ?? '');
        $templateProcessor->setValue('municipality', $intakes?->municipality ?? '');
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
            $templateProcessor->setValue('age#' . $rowIndex, $family?->age ?? '');
            $templateProcessor->setValue('relationship#' . $rowIndex, $family?->relationship ?? '');
            $templateProcessor->setValue('educ_attainment#' . $rowIndex, $family?->educ_attainment ?? '');
            $templateProcessor->setValue('remarks#' . $rowIndex, $family?->remarks ?? '');
        }

        $referral = Referral::find($id);
        $templateProcessor->setValue('content', ucwords($referral?->content ?? ''));

        $remarks = Remark::find($id);
        $templateProcessor->setValue('remark', ucwords($remarks?->content ?? ''));

        $fileName = $intakes->last_name;
        $templateProcessor->saveAs($fileName. '.docx');

        return response()->download($fileName.'.docx')->deleteFileAfterSend(true);
    }

    // Update Intake Sheets
    public function update(Request $request, $id)
    {
        $personalData = PersonalInformation::findOrFail($id);

        // $personalData->update($request->all());

        // return $personalData;

        // Initialize an array for storing created family compositions
        $famComps = [];

        // Loop through the request data (assuming it contains family composition records)
        foreach ($request->input('family_compositions', []) as $familyCompositionData) {
            // Add the created_by field for each family composition
            $familyCompositionData['created_by'] = $id;

            // Create a new FamilyComposition record and add it to the array
            $famComps[] = FamilyComposition::create($familyCompositionData);
        }

        // Update the personal data with the request data
        $personalData->update($request->except('family_compositions'));  // Make sure to exclude the family_compositions key

        return response()->json([
            'personal_data' => $personalData,
            'family_compositions' => $famComps
        ]);
    }
}
