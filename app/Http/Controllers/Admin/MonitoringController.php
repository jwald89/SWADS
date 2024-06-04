<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sector;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectorResource;
use App\Http\Resources\PersonalDetailResource;

class MonitoringController extends Controller
{
    public function index()
    {
        return inertia('MonitoringIndex');
    }

    public function create()
    {
        $dataMonitors = PersonalDetailResource::collection(PersonalInformation::all());
        $sectors = SectorResource::collection(Sector::all());

        return inertia('MonitoringCreate', [
            'dataMonitors' => $dataMonitors,
            'sectors' => $sectors,
        ]);
    }
}
