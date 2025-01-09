<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Office;
use App\Models\Sector;
use App\Models\Liaison;
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
use App\Http\Resources\LiaisonResource;
use App\Http\Resources\AdministerResource;
use App\Http\Resources\PersonalDetailResource;

class MonitoringController extends Controller
{
    public function index()
    {

        if (Auth::user()->role_type === 'ADMIN' || Auth::user()->role_type === 'USER' || Auth::user()->role_type === 'LIAISON')
        {
            $monitoringData = Monitoring::with(['intake', 'sector'])
                ->when(request()->search !== '', function ($query) {
                    $query->where(function ($query) {
                        $query->where('claimant', 'like', '%' . request()->search . '%')
                              ->orWhere('assistance_type', 'like', '%' . request()->search . '%')
                              ->orWhere('sector', 'like', '%' . request()->search . '%')
                              ->orWhere('client_type', 'like', '%' . request()->search . '%')
                              ->orWhere('municipality', 'like', '%' . request()->search . '%');
                    });
                })
                ->when(Auth::user()->role_type === 'LIAISON', function ($query) {
                    $query->where('liaison', '=', Auth::user()->id);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        return inertia('MonitoringIndex', [
            'monitoring' => $monitoringData,
            'search' => request()->search ?? ''
        ]);
    }

    public function create()
    {
        $intakeData = PersonalDetailResource::collection(PersonalInformation::all());
        $sectors = SectorResource::collection(Sector::all());
        $admins = AdministerResource::collection(StaffAdministered::all());
        $officeCharge = OfficeResource::collection(Office::all());
        $users = UserResource::collection(User::where('role_type', '=', 'LIAISON')->get());
        // $liaisons = LiaisonResource::collection(Liaison::all());


        return inertia('MonitoringCreate', [
            'intakeData' => $intakeData,
            'sectors' => $sectors,
            'admins' => $admins,
            'officeCharge' => $officeCharge,
            'status' => StatusType::names(),
            'users' => $users,
            // 'liaisons' => $liaisons,
        ]);
    }

    public function getMonitoringRecords()
    {
        $monitoringRecords = Monitoring::all(['claimant']);
        return response()->json($monitoringRecords);
    }


    public function store(MonitorRequest $request)
    {
        $userId = Auth::id();

        $data = Monitoring::create(
            array_merge($request->all(), ['created_by' => $userId])
        );

        return response()->json($data, 201);
    }


    public function edit($id)
    {
        $monitoring = Monitoring::with(['user', 'intake'])->findOrFail($id);
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


    public function update(Request $request, $id)
    {
        $monitoring = Monitoring::with(['user'])->findOrFail($id);

        $monitoring->update($request->all());

        return $monitoring;
    }
}
