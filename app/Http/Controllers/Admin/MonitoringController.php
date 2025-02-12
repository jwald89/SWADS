<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Office;
use App\Models\Sector;
use App\Enums\StatusType;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\AssistanceType;
use App\Models\FamilyComposition;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MonitorRequest;
use App\Http\Resources\OfficeResource;
use App\Http\Resources\SectorResource;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\PersonalDetailResource;
use App\Http\Resources\FamilyCompositionResource;
use App\Http\Resources\MunicipalityResource;
use App\Models\Municipality;

class MonitoringController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role_type === 'ADMIN' || Auth::user()->role_type === 'USER' || Auth::user()->role_type === 'LIAISON') {
            $monitoringData = Monitoring::with(['intake', 'sector', 'assistance', 'brgy', 'municipal'])
                ->when(Auth::user()->role_type === 'LIAISON', function ($query) {
                    $query->where('liaison', Auth::user()->id)
                        ->where(function ($query) {
                            $search = request()->search;
                            $query->orWhereHas('intake', function ($claimant) use ($search) {
                                        $claimant->where('first_name', 'like', '%' . $search . '%')
                                                ->orWhere('middle_name', 'like', '%' . $search . '%')
                                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                                ->orWhereRaw("CONCAT(first_name, ' ', middle_name) like ?", ['%' . $search . '%'])
                                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $search . '%'])
                                                ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) like ?", ['%' . $search . '%']);
                                    });
                                    // ->orWhereHas('assistance', function ($assistance) use ($search) {
                                    //     $assistance->where('name', 'like', '%' . $search . '%');
                                    // })
                                    // ->orWhereHas('sector', function ($sector) use ($search) {
                                    //     $sector->where('name', 'like', '%' . $search . '%');
                                    // });
                        });
                })
                ->when(Auth::user()->role_type !== 'LIAISON', function ($query) {
                    $query->where(function ($query) {
                        $search = request()->search;
                        $query->orWhereHas('intake', function ($claimant) use ($search) {
                                  $claimant->where('first_name', 'like', '%' . $search . '%')
                                           ->orWhere('middle_name', 'like', '%' . $search . '%')
                                           ->orWhere('last_name', 'like', '%' . $search . '%')
                                           ->orWhereRaw("CONCAT(first_name, ' ', middle_name) like ?", ['%' . $search . '%'])
                                           ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $search . '%'])
                                           ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) like ?", ['%' . $search . '%']);
                              });
                            //   ->orWhereHas('assistance', function ($assistance) use ($search) {
                            //       $assistance->where('name', 'like', '%' . $search . '%');
                            //   })
                            //   ->orWhereHas('sector', function ($sector) use ($search) {
                            //       $sector->where('name', 'like', '%' . $search . '%');
                            //   });
                    });
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        $assistanceType = AssistanceResource::collection(AssistanceType::all());
        $sectorType = SectorResource::collection(Sector::all());
        $municipalityName = MunicipalityResource::collection(Municipality::all());

        return inertia('MonitoringIndex', [
            'monitorings' => $monitoringData,
            'search' => request()->search ?? '',
            'assistanceType' => $assistanceType,
            'sectorType' => $sectorType,
            'municipalityName' => $municipalityName
        ]);
    }

    /**
     * Display data on the table.
    */
    public function create()
    {
        $intakeData = PersonalDetailResource::collection(PersonalInformation::with(['assistance', 'user', 'brgy', 'municipal'])->get());
        $sectors = SectorResource::collection(Sector::all());
        $officeCharge = OfficeResource::collection(Office::all());
        $users = UserResource::collection(User::where('role_type', '=', 'LIAISON')->get());

        return inertia('MonitoringCreate', [
            'intakeData' => $intakeData,
            'sectors' => $sectors,
            'officeCharge' => $officeCharge,
            'status' => StatusType::names(),
            'users' => $users,
        ]);
    }


     /**
     * Get data on monitorings datatable.
    */
    public function getMonitoringRecords()
    {
        $monitoringRecords = Monitoring::all(['claimant']);

        return response()->json($monitoringRecords);
    }


     /**
     * Get data beneficiary on the family_composition datatable.
    */
    public function fetchBeneficiaries(Request $request)
    {
        $claimantId = $request->input('claimant');

        // Fetch beneficiaries where `applicant_id` matches the claimant's ID
        $beneficiaries = FamilyCompositionResource::collection(FamilyComposition::where('applicant_id', $claimantId)->get());

        return response()->json($beneficiaries);
    }


    /**
     * Store a newly created resource in storage.
    */
    public function store(MonitorRequest $request)
    {
        $userId = Auth::id();

        $data = Monitoring::create(
            array_merge($request->all(), ['created_by' => $userId])
        );

        return response()->json($data, 201);
    }


    /**
    * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        $monitoring = Monitoring::with(['user', 'intake', 'assistance', 'brgy', 'municipal'])->findOrFail($id);
        $sectors = SectorResource::collection(Sector::all());
        $officeCharge = OfficeResource::collection(Office::all());
        $users = UserResource::collection(User::where('role_type', '=', 'LIAISON')->get());

        $staffAdmin = '';

        // Retrieve the created_by user details
        $createdByUser = null;
        if ($monitoring && $monitoring->created_by !== null) {
            $createdByUser = User::find($monitoring->created_by);
        }

        if ($createdByUser) {
            $staffAdmin = ucwords($createdByUser->first_name) . ' '
                . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($createdByUser->last_name);
        }

        return inertia('EditMonitoring', [
            'dataMonitors' => $monitoring,
            'sectors' => $sectors,
            'officeCharge' => $officeCharge,
            'users' => $users,
            'staffAdmin' => $staffAdmin,
        ]);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(MonitorRequest $request, $id)
    {
        $monitoring = Monitoring::with(['user'])->findOrFail($id);

        $monitoring->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return response()->json(['success' => true]);
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $monitoring = Monitoring::find($id);

        $monitoring->delete();

        return response()->json(['success' => true]);
    }

     /**
     * Show the data in table.
     */
    public function show($id)
    {
        $monitorings = Monitoring::with(['intake', 'sector', 'assistance', 'user', 'brgy', 'municipal'])->find($id);

        // Initialize variables
        $createdBy = '';
        $modifiedBy = '';

        // Retrieve the created_by user details
        $createdByUser = null;
        if ($monitorings && $monitorings->created_by !== null) {
            $createdByUser = User::find($monitorings->created_by);
        }

        if ($createdByUser) {
            $createdBy = ucwords($createdByUser->first_name) . ' '
                . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($createdByUser->last_name);
        }

        // Retrieve the staff administered details
        $staffAdmin = null;
        if($monitorings && $monitorings->staff_admin)
        {
            $staffAdmin = User::find($monitorings->staff_admin);
        }

        if ($staffAdmin) {
            $staffAdmin = ucwords($staffAdmin->first_name) . ' '
                . ucfirst(substr($staffAdmin->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($staffAdmin->last_name);
        }

        // Retrieve the modified_by user details
        $modifiedByUser = null;
        if ($monitorings && $monitorings->modified_by !== null) {
            $modifiedByUser = User::find($monitorings->modified_by);
        }

        if ($modifiedByUser) {
            $modifiedBy = ucwords($modifiedByUser->first_name) . ' '
                . ucfirst(substr($modifiedByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($modifiedByUser->last_name);
        }

        return inertia('ShowMonitoring', [
            'monitorings' => $monitorings,
            'createdBy' => $createdBy,
            'modifiedBy' => $modifiedBy,
            'staffAdmin' => $staffAdmin,
        ]);
    }


    /**
     * Filter the specified assistance, sector, municipality, month and year
     */
    public function filter($assistanceId = '*', $sectorId = '*', $municipalId = '*', $month = '*')
    {
        $data = Monitoring::with(['intake', 'assistance', 'sector', 'municipal']);


        // // If the user is admin
        // if (Auth::user()->role_type === 'ADMIN' || Auth::user()->role_type === 'USER') {
        //     // If sectorId is "All", show all data regardless of municipality
        //     if ($sectorId == '*') {
        //         // No additional filtering by municipality for admins
        //     } else {
        //         // If a specific sector is selected, filter by that sector
        //         $data->where('sector', $sectorId);
        //     }
        // } else if (Auth::user()->role_type === 'MUNICIPAL') {
        //     // If the user is municipal
        //     if ($sectorId == '*') {
        //         // Show data for the user's municipality
        //         $data->where('municipality', Auth::user()->municipality);
        //     } else {
        //         // If a specific sector is selected, filter by sector and municipality
        //         $data->where('sector', $sectorId)
        //             ->where('municipality', Auth::user()->municipality);
        //     }
        // }


        if ($assistanceId !== '*') {
            $data->where('assistance_type', $assistanceId);
        }

        if ($sectorId !== '*') {
            $data->where('sector', $sectorId);
        }

        if ($municipalId !== '*') {
            $data->where('municipality', $municipalId);
        }

        if ($month !== '*') {
            $data->whereMonth('date_intake', $month);
        }


        return response()->json($data->get());
    }
}
