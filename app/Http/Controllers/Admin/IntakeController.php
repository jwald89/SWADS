<?php

namespace App\Http\Controllers\Admin;

use Log;
use Carbon\Carbon;
use App\Enums\Month;
use App\Models\User;
use App\Models\Office;
use App\Models\Remark;
use App\Models\Sector;
use App\Models\Barangay;
use App\Models\Referral;
use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use App\Models\Monitoring;
use App\Models\Municipality;
use Illuminate\Http\Request;

use App\Models\AssistanceType;
use App\Models\Classification;
use App\Models\IndigentPeople;
use App\Models\FamRelationship;
use App\Models\FamilyComposition;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\IntakeRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OfficeResource;
use App\Http\Resources\SectorResource;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\IndigentResource;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\MunicipalityResource;
use App\Http\Resources\ClassificationResource;
use App\Http\Resources\FamRelationshipResource;

class IntakeController extends Controller
{
    /**
     *  Personal Information data table display
     */
    public function index()
    {
        $perInfos = PersonalInformation::with(['assistance', 'municipal', 'brgy', 'sectorName'])
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
                    ->orderBy('date_intake', 'DESC')
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
        $classType = ClassificationResource::collection(Classification::all());
        $famRelation = FamRelationshipResource::collection(FamRelationship::all());

        return inertia('IntakeCreate', [
            'assistances' => $assistances,
            'sectorType' => $sectorType,
            'barangays' => $barangays,
            'municipality' => $municipality,
            'indigents' => $indigents,
            'officeCharge' => $officeCharge,
            'classType' => $classType,
            'famRelation' => $famRelation,
            'civilStatus' => CivilStatus::values(),
            'gender' => GenderTypes::names(),
        ]);
    }

    /**
     *  Personal Information store process
     */
    public function storeP1(IntakeRequest $request)
    {
        $userId = Auth::id();

       // Fetch the highest current case_no
        $lastCaseNo = PersonalInformation::orderBy('case_no', 'desc')->first();
        $nextCaseNumber = 1;

        if ($lastCaseNo) {
            // Extract the number from the last case_no
            preg_match('/(\d+)/', $lastCaseNo->case_no, $matches);
            $nextCaseNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        }

        // Create the new case_no
        $caseNo = $nextCaseNumber;

        // Create the personal information record
        $personalInformation = PersonalInformation::create(
            array_merge($request->all(), [
                'case_no' => $caseNo,
                'created_by' => $userId
            ])
        );
        // Create temporary family composition record
        FamilyComposition::create([
            'applicant_id' => $personalInformation->id,
            'firstname' => null,
            'lastname' => null,
            'age' => null,
            'relationship' => null,
            'educ_attainment' => null,
            'remarks' => null,
            'created_by' => $userId
        ]);

        // Create temporary referral record
        Referral::create([
            'applicant_id' => $personalInformation->id,
            'content' => null,
            'created_by' => $userId
        ]);

        // Create temporary remark record
        Remark::create([
            'applicant_id' => $personalInformation->id,
            'content' => null,
            'created_by' => $userId
        ]);

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
            '*.age' => 'required|integer',
            '*.relationship' => 'required',
            '*.educ_attainment' => 'required|string|max:255',
            '*.remarks' => 'required|string|max:255',
            '*.applicant_id' => 'required|integer',
        ]);

        $userId = Auth::id();
        $famComps = [];

       // Determine the count of records in the request
        $recordCount = count($request->all());

        // If there's only one record, check if it exists and update it
        if ($recordCount === 1) {
            $familyComposition = $request->input(0); // Access the first item directly
            $applicantId = $familyComposition['applicant_id'];

            // Try to find an existing record
            $existingFamilyComposition = FamilyComposition::where('applicant_id', $applicantId)->first();

            if ($existingFamilyComposition) {
                // Update the existing record
                $existingFamilyComposition->update(array_merge($familyComposition, ['created_by' => $userId]));
                $famComps[] = $existingFamilyComposition;
            } else {
                // Create a new record if none exists
                $familyComposition['created_by'] = $userId;
                $famComps[] = FamilyComposition::create($familyComposition);
            }
        } else {
            // If there are two or more records, delete existing ones with the same applicant_id
            $applicantIds = collect($request->all())->pluck('applicant_id')->unique();
            FamilyComposition::whereIn('applicant_id', $applicantIds)->delete();

            // Create new records from the request
            foreach ($request->all() as $familyComposition) {
                $familyComposition['created_by'] = $userId;
                $famComps[] = FamilyComposition::create($familyComposition);
            }
        }


        return response()->json($famComps, 201);
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

        $existingReferral = Referral::where('applicant_id', $request->applicant_id)->first();

        if ($existingReferral) {
            $existingReferral->update([
                'content' => $request->content,
                'created_by' => $userId
            ]);

            $referrals = $existingReferral;
        } else {
            $referrals = Referral::create(
                array_merge($request->all(), ['created_by' => $userId])
            );
        }

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
            'content' => 'required',
            'cash_assistance' => 'required'
        ]);

        $userId = Auth::id();

        $existingRemark = Remark::where('applicant_id', $request->applicant_id)->first();

        if ($existingRemark) {
            $existingRemark->update([
                'content' => $request->content,
                'cash_assistance' => $request->cash_assistance,
                'created_by' => $userId
            ]);

            $remarks = $existingRemark;
        } else {
            $remarks = Remark::create(
                array_merge($request->all(), ['created_by' => $userId])
            );
        }

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
        $intakes = PersonalInformation::with([
            'famCompose.famRelation',
            'referral',
            'remark',
            'assistance',
            'brgy',
            'municipal',
            'sectorName',
            'chargingOffice',
            'indigent',
            'user',
            'classific',
        ])->find($id);

        $createdBy = '';
        $modifiedBy = '';

        // Retrieve the created_by user details
        $createdByUser = null;
        if ($intakes && $intakes->created_by !== null) {
            $createdByUser = User::find($intakes->created_by);
        }

        if ($createdByUser) {
            $createdBy = ucwords($createdByUser->first_name) . ' '
                . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($createdByUser->last_name);
        }

        // Retrieve the modified_by user details
        $modifiedByUser = null;
        if ($intakes && $intakes->modified_by !== null) {
            $modifiedByUser = User::find($intakes->modified_by);
        }

        if ($modifiedByUser) {
            $modifiedBy = ucwords($modifiedByUser->first_name) . ' '
                . ucfirst(substr($modifiedByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($modifiedByUser->last_name);
        }

        return inertia('ShowIntake', [
            'intakes' => $intakes,
            'createdBy' => $createdBy,
            'modifiedBy' => $modifiedBy,
        ]);
    }

    /**
     * Intake Sheet edit process
     */
    public function edit($id)
    {
        $intakes = PersonalInformation::with([
            'famCompose.famRelation',
            'referral',
            'remark',
            'brgy',
            'municipal',
            'sectorName',
            'chargingOffice',
            'indigent',
            'classific',
        ])->find($id);

        $assistances = AssistanceResource::collection(AssistanceType::all());
        $sectorType = SectorResource::collection(Sector::all());
        $officeCharge = OfficeResource::collection(Office::all());
        $assistances = AssistanceResource::collection(AssistanceType::all());
        $municipality = MunicipalityResource::collection(Municipality::all());
        $barangays = BarangayResource::collection(Barangay::all());
        $indigents = IndigentResource::collection(IndigentPeople::all());
        $classType = ClassificationResource::collection(Classification::all());
        $famRelation = FamRelationshipResource::collection(FamRelationship::all());

        return inertia('EditIntake', [
            'intakes' => $intakes,
            'assistances' => $assistances,
            'sectorType' => $sectorType,
            'officeCharge' => $officeCharge,
            'indigents' => $indigents,
            'classType' => $classType,
            'barangays' => $barangays,
            'municipality' => $municipality,
            'relationships' => $famRelation,
            'civilStatus' => CivilStatus::values(),
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
                . ($createdByUser->middle_init === null ? "" : strtoupper(substr($createdByUser->middle_init, 0, 1)) . '. ')
                . strtoupper($createdByUser->last_name);
        }

        $famCompose = FamilyComposition::with(['famRelation'])
                        ->where('applicant_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $referrals = DB::table('referrals')
            ->select('id', 'content')
            ->where('applicant_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $remarks = DB::table('remarks')
            ->select('id', 'content', 'cash_assistance')
            ->where('applicant_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = App::make('snappy.pdf.wrapper');

        $pdf->loadView('intakes-sheet-print', compact('intakes', 'famCompose', 'referrals', 'remarks', 'createdBy'))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 8)
            ->setOption('margin-bottom', 10);

        return $pdf->inline();
    }

    /**
     * Print certificate of eligibility
     */
    public function coePrint($id)
    {
        $intakes = PersonalInformation::with(['assistance', 'user', 'brgy', 'municipal', 'chargingOffice'])
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
            . ($createdByUser->middle_init === null ? "" : strtoupper(substr($createdByUser->middle_init, 0, 1)) . '. ')
            . ucfirst($createdByUser->last_name);
        }


        $pdf = App::make('snappy.pdf.wrapper');

        $pdf->loadView('coe-print', compact('intakes', 'createdBy'))
            ->setPaper('letter')
            ->setOption('enable-local-file-access', true)
            ->setOrientation('portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 0);

        return $pdf->inline();
    }


    /**
     *  Exporting process in ms excel
     */
    public function export($id)
    {
        $intakes = PersonalInformation::with(['assistance', 'brgy', 'municipal', 'chargingOffice'])->findOrFail($id);

        $createdBy = '';

         // Retrieve the created_by user details
         $createdByUser = null;
         if ($intakes && $intakes->created_by !== null) {
             $createdByUser = User::find($intakes->created_by);
         }

         if ($createdByUser) {
            $createdBy = ucfirst($createdByUser->first_name) . ' '
                . ($createdByUser->middle_init === null ? "" : strtoupper(substr($createdByUser->middle_init, 0, 1)) . ". ")
                . ucfirst($createdByUser->last_name);
        }

        $templateProcessor = new TemplateProcessor('word-template/intake-sheet.docx');
        $templateProcessor->setValue('case_no', $intakes?->case_no);
        $templateProcessor->setValue('caseType', $intakes?->case);
        $templateProcessor->setValue('first_name', strtoupper($intakes?->first_name ?? ''));
        $templateProcessor->setValue('middle_name', $intakes->middle_name ? strtoupper(substr($intakes?->middle_name, 0, 1)) . "." : "");
        $templateProcessor->setValue('last_name', strtoupper($intakes?->last_name ?? ''));
        $templateProcessor->setValue('extn_name', $intakes->extn_name ? ", " . strtoupper($intakes?->extn_name ?? '') : "");
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
        $templateProcessor->setValue('fname', strtoupper($intakes?->chargingOffice->first_name) ?? '');
        $templateProcessor->setValue('mname', strtoupper(substr($intakes?->chargingOffice->middle_name, 0, 1)) ?? '');
        $templateProcessor->setValue('lname', strtoupper($intakes?->chargingOffice->last_name) ?? '');
        $templateProcessor->setValue('title', $intakes?->chargingOffice->title ?? '');

        $families = FamilyComposition::with(['famRelation'])->where('applicant_id', $id)->get();
        $templateProcessor->cloneRow('firstname', $families->count());

        foreach ($families as $index => $family) {
            $rowIndex = $index + 1;
            $templateProcessor->setValue('firstname#' . $rowIndex, ucwords($family?->firstname ?? ''));
            $templateProcessor->setValue('middlename#' . $rowIndex, ucwords(substr($family?->middlename ?? '', 0, 1)));
            $templateProcessor->setValue('lastname#' . $rowIndex, ucwords($family?->lastname ?? ''));
            $templateProcessor->setValue('ageNo#' . $rowIndex, $family?->age ? $family?->age . " years old" : '');
            $templateProcessor->setValue('relationship#' . $rowIndex, $family?->famRelation->name ?? '');
            $templateProcessor->setValue('educ_attainment#' . $rowIndex, ucwords($family?->educ_attainment ?? ''));
            $templateProcessor->setValue('remarks#' . $rowIndex, ucwords($family?->remarks ?? ''));
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
            $userId = Auth::id();
            $currentDate = Carbon::now();

            $personalData = PersonalInformation::findOrFail($id);
            $personalData->update(array_merge(
                $request->except('family_compositions', 'referral', 'remark'),
                ['modified_by' => $userId, 'modified_date' => $currentDate]
            ));

            // Update the monitoring data based on the claimant
            $dataMonitoring = Monitoring::where('claimant', $id)->first();
            if ($dataMonitoring) {
                $dataMonitoring->update([
                    'age' => $personalData->age,
                    'sex' => $personalData->sex,
                    'contact_no' => $personalData->contact_no,
                    'sector' => $personalData->sector_type,
                    'assistance_type' => $personalData->category,
                    'barangay' => $personalData->barangay,
                    'municipality' => $personalData->municipality,
                    'charges' => $personalData->ofis_charge,
                    'date_intake' => $personalData->date_intake,
                    'modified_by' => $userId,
                    'modified_date' => $currentDate,
                ]);
            }

            foreach($request->fam_compose as $familyCompose) {
                if(isset($familyCompose['id'])) {
                    $family = FamilyComposition::find($familyCompose['id']);
                    $family->update(array_merge(
                        $familyCompose,
                        ['modified_by' => $userId, 'modified_date' => $currentDate]
                    ));
                }else {
                    FamilyComposition::create(array_merge(
                        $familyCompose,
                        ['applicant_id' => $id, 'created_by' => $userId]
                    ));
                }
            }

            foreach ($request->referral as $referralData) {
                $referral = Referral::find($referralData['id']);
                $referral->update(array_merge(
                    $referralData,
                    ['modified_by' => $userId, 'modified_date' => $currentDate]
                ));
            }

            foreach ($request->remark as $remarkData) {
                $remark = Remark::find($remarkData['id']);
                $remark->update(array_merge(
                    $remarkData,
                    ['modified_by' => $userId, 'modified_date' => $currentDate]
                ));
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
        return DB::transaction(function () use ($request) {
            // Retrieve the PersonalInformation record with related models
            $data = PersonalInformation::with(['famCompose', 'referral', 'remark'])->find($request->id);

            if ($data) {
                // Set the deleted_by field to the authenticated user's ID
                $data->deleted_by = Auth::id();

                try {
                    $data->save(); // Save the changes to update the deleted_by field
                    \Log::info('Record saved successfully.');
                } catch (\Exception $e) {
                    \Log::error('Error saving record: ' . $e->getMessage());
                    return response()->json(['success' => false, 'message' => 'Error saving record'], 500);
                }

                // Retrieve the record again to check if the deleted_by field is set
                $data = PersonalInformation::find($request->id);

                // Delete related records
                $data->famCompose()->each(function ($fam) {
                    $fam->delete();
                });

                $data->referral()->each(function ($ref) {
                    $ref->delete();
                });

                $data->remark()->each(function ($rem) {
                    $rem->delete();
                });

                 // Now delete the main record
                try {
                    $data->delete();
                    \Log::info('Main record deleted successfully.');
                } catch (\Exception $e) {
                    \Log::error('Error deleting main record: ' . $e->getMessage());
                    return response()->json(['success' => false, 'message' => 'Error deleting main record'], 500);
                }

                return response()->json(['success' => true], 200);
            }

            return response()->json(['success' => false, 'message' => 'Record not found'], 404);
        });
    }


    /**
     * Filter the specified assistance, municipality, month and year
     */
    public function filter($assistanceId = '*', $municipalId = '*', $month = '*')
    {
        $data = PersonalInformation::with(['assistance', 'municipal', 'brgy', 'sectorName']);

        if ($assistanceId !== '*') {
            $data->where('category', $assistanceId);
        }

        if ($municipalId !== '*') {
            $data->where('municipality', $municipalId);
        }

        if ($month !== '*') {
            $data->whereMonth('date_intake', $month);
        }

        // return response()->json($data->orderBy('date_intake', 'DESC')->get());


        $paginatedData = $data->orderBy('created_at', 'DESC')->paginate(10);

        if ($paginatedData->isEmpty()) {
            return response()->json(['message' => 'No data found']);
        }

        return $paginatedData;
    }


    /**
     * Delete the data from the datatable personal information, family composition, referral and remark
     */
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $intakes = PersonalInformation::with(['famCompose', 'referral', 'remark', 'monitoring'])->find($id);

            if (!$intakes) {
                return response()->json(['success' => false, 'message' => 'Record not found'], 404);
            }

            if ($intakes->deleted_by === null) {
                $intakes->deleted_by = Auth::id();
                $intakes->save();
            }

            foreach($intakes->monitoring as $monitoring)
            {
                if ($monitoring->deleted_by === null) {
                    $monitoring->deleted_by = Auth::id();
                    $monitoring->save();
                }
            }

            $intakes->famCompose()->delete();
            $intakes->referral()->delete();
            $intakes->remark()->delete();
            $intakes->monitoring()->delete();
            $intakes->delete();

            return response()->json(['success' => true]);
        });
    }

    /**
     * Delete a family member by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFamilyMember($id)
    {
        return DB::transaction(function() use($id) {
            $familyMember = FamilyComposition::find($id);

            if (!$familyMember) {
                return response()->json(['message' => 'Family member not found.'], 404);
            }

            $familyMember->delete();

            return response()->json(['message' => 'Family member deleted successfully.'], 200);
        });
    }
}
