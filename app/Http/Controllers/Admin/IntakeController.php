<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CivilStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\IntakeRequest;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\MunicipalityResource;
use App\Models\AssistanceType;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;

class IntakeController extends Controller
{
    public function index()
    {
        return inertia('IntakeIndex');
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
            'civilStatus' => CivilStatus::names()
        ]);
    }

    public function store(IntakeRequest $request)
    {
        $basicInfo = new PersonalInformation;


    }
}
