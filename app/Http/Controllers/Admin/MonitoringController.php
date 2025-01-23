<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Office;
use App\Models\Sector;
use App\Enums\StatusType;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\StaffAdministered;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MonitorRequest;
use App\Http\Resources\OfficeResource;
use App\Http\Resources\SectorResource;
use App\Http\Resources\AdministerResource;
use App\Http\Resources\PersonalDetailResource;

class MonitoringController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role_type === 'ADMIN' || Auth::user()->role_type === 'USER' || Auth::user()->role_type === 'LIAISON') {
            $monitoringData = Monitoring::with(['intake', 'sector', 'assistance'])
                ->when(Auth::user()->role_type === 'LIAISON', function ($query) {
                    $query->where('liaison', Auth::user()->id)
                        ->where(function ($query) {
                            $search = request()->search;
                            $query->where('client_type', 'like', '%' . $search . '%')
                                    ->orWhere('municipality', 'like', '%' . $search . '%')
                                    ->orWhereHas('intake', function ($claimant) use ($search) {
                                        $claimant->where('first_name', 'like', '%' . $search . '%')
                                                ->orWhere('middle_name', 'like', '%' . $search . '%')
                                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                                ->orWhereRaw("CONCAT(first_name, ' ', middle_name) like ?", ['%' . $search . '%'])
                                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $search . '%'])
                                                ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) like ?", ['%' . $search . '%']);
                                    })
                                    ->orWhereHas('assistance', function ($assistance) use ($search) {
                                        $assistance->where('name', 'like', '%' . $search . '%');
                                    })
                                    ->orWhereHas('sector', function ($sector) use ($search) {
                                        $sector->where('name', 'like', '%' . $search . '%');
                                    });
                        });
                })
                ->when(Auth::user()->role_type !== 'LIAISON', function ($query) {
                    $query->where(function ($query) {
                        $search = request()->search;
                        $query->where('client_type', 'like', '%' . $search . '%')
                              ->orWhere('municipality', 'like', '%' . $search . '%')
                              ->orWhereHas('intake', function ($claimant) use ($search) {
                                  $claimant->where('first_name', 'like', '%' . $search . '%')
                                           ->orWhere('middle_name', 'like', '%' . $search . '%')
                                           ->orWhere('last_name', 'like', '%' . $search . '%')
                                           ->orWhereRaw("CONCAT(first_name, ' ', middle_name) like ?", ['%' . $search . '%'])
                                           ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $search . '%'])
                                           ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) like ?", ['%' . $search . '%']);
                              })
                              ->orWhereHas('assistance', function ($assistance) use ($search) {
                                  $assistance->where('name', 'like', '%' . $search . '%');
                              })
                              ->orWhereHas('sector', function ($sector) use ($search) {
                                  $sector->where('name', 'like', '%' . $search . '%');
                              });
                    });
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        return inertia('MonitoringIndex', [
            'monitoring' => $monitoringData,
            'search' => request()->search ?? ''
        ]);
    }

    /**
     * Display data on the table.
    */
    public function create()
    {
        $intakeData = PersonalDetailResource::collection(PersonalInformation::all());
        $sectors = SectorResource::collection(Sector::all());
        $admins = AdministerResource::collection(StaffAdministered::all());
        $officeCharge = OfficeResource::collection(Office::all());
        $users = UserResource::collection(User::where('role_type', '=', 'LIAISON')->get());

        return inertia('MonitoringCreate', [
            'intakeData' => $intakeData,
            'sectors' => $sectors,
            'admins' => $admins,
            'officeCharge' => $officeCharge,
            'status' => StatusType::names(),
            'users' => $users,
        ]);
    }

    public function getMonitoringRecords()
    {
        $monitoringRecords = Monitoring::all(['claimant']);
        return response()->json($monitoringRecords);
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
        $monitoring = Monitoring::with(['user', 'intake', 'assistance'])->findOrFail($id);
        $sectors = SectorResource::collection(Sector::all());
        $admins = AdministerResource::collection(StaffAdministered::all());
        $officeCharge = OfficeResource::collection(Office::all());
        $users = UserResource::collection(User::where('role_type', '=', 'LIAISON')->get());

        return inertia('EditMonitoring', [
            'dataMonitors' => $monitoring,
            'sectors' => $sectors,
            'admins' => $admins,
            'officeCharge' => $officeCharge,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, $id)
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
        $monitorings = Monitoring::with(['intake', 'sector', 'assistance', 'user'])->find($id);

        // Initialize variables
        $createdBy = '';
        $modifiedBy = '';

        // Retrieve the created_by user details
        $createdByUser = null;
        if ($monitorings && $monitorings->created_by !== null) {
            $createdByUser = User::find($monitorings->created_by);
        }

        if ($createdByUser) {
            $createdBy = ucfirst($createdByUser->first_name) . ' '
                . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($createdByUser->last_name);
        }

        // Retrieve the modified_by user details
        $modifiedByUser = null;
        if ($monitorings && $monitorings->modified_by !== null) {
            $modifiedByUser = User::find($monitorings->modified_by);
        }

        if ($modifiedByUser) {
            $modifiedBy = ucfirst($modifiedByUser->first_name) . ' '
                . ucfirst(substr($modifiedByUser->middle_init ?? '', 0, 1)) . '. '
                . ucfirst($modifiedByUser->last_name);
        }

        return inertia('ShowMonitoring', [
            'monitorings' => $monitorings,
            'createdBy' => $createdBy,
            'modifiedBy' => $modifiedBy
        ]);
    }


}
