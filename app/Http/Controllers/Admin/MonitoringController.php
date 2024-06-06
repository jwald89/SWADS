<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sector;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\MonitorRequest;
use App\Http\Resources\AdministerResource;
use App\Http\Resources\SectorResource;
use App\Http\Resources\PersonalDetailResource;
use App\Models\StaffAdministered;
use Illuminate\Contracts\Queue\Monitor;

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

        return inertia('MonitoringCreate', [
            'dataMonitors' => $dataMonitors,
            'sectors' => $sectors,
            'admins' => $admins,
        ]);
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
