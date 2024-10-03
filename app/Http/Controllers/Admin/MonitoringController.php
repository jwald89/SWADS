<?php

namespace App\Http\Controllers\Admin;

use App\Models\Office;
use App\Models\Sector;
use App\Models\Liaison;
use App\Enums\StatusType;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\StaffAdministered;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\MonitorRequest;
use App\Http\Resources\OfficeResource;
use App\Http\Resources\SectorResource;
use App\Http\Resources\LiaisonResource;
use Illuminate\Contracts\Queue\Monitor;
use App\Http\Resources\AdministerResource;
use App\Http\Resources\PersonalDetailResource;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitoringData = Monitoring::get();

        return inertia('MonitoringIndex', [
            'monitorings' => $monitoringData
        ]);
    }

    public function create()
    {
        $dataMonitors = PersonalDetailResource::collection(PersonalInformation::all());
        $sectors = SectorResource::collection(Sector::all());
        $admins = AdministerResource::collection(StaffAdministered::all());
        $liaisons = LiaisonResource::collection(Liaison::all());
        $offices = OfficeResource::collection(Office::all());

        return inertia('MonitoringCreate', [
            'dataMonitors' => $dataMonitors,
            'sectors' => $sectors,
            'admins' => $admins,
            'liaisons' => $liaisons,
            'offices' => $offices,
            'status' => StatusType::names(),
        ]);
    }

    public function getMonitoringRecords()
    {
        $monitoringRecords = Monitoring::all(['claimant']);
        return response()->json($monitoringRecords);
    }


    public function store(MonitorRequest $request)
    {
        $data = Monitoring::create($request->all());
        $dataJson = $data->toJson();

        return response()->json([
            'message' => 'Personal information created successfully.',
            'data' => json_decode($dataJson, true),
        ]);
    }
}
