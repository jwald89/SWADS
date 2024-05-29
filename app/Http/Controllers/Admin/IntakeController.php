<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barangay;
use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\AssistanceType;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\IntakeRequest;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\AssistanceResource;
use App\Http\Resources\MunicipalityResource;

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'classification' => 'required|string',
            'category' => 'required|string',
            'date_intake' => 'required|date',
            'last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'required|string|max:100',
            'nick_name' => 'required|string|max:100',
            'extn_name' => 'required|string|max:100',
            'age' => 'required|string',
            'birthdate' => 'required|date',
            'sex' => 'required|in:' . implode(',', GenderTypes::values()),
            'purok' => 'required|string',
            'street' => 'required|string',
            'barangay' => 'required|string',
            'municipality' => 'required|string',
            // 'civil_stats' => 'required|in:' . implode(',', CivilStatus::values()),
            'job' => 'nullable|string',
            'contact_no' => 'nullable|string',
            'income' => 'nullable|string',
        ]);

        // Create a new personal_information record
        $personalInformation = PersonalInformation::create($validatedData);

        // Convert the personal_information record to JSON
        $personalInformationJson = $personalInformation->toJson();


        // Return the JSON response
        return response()->json([
            'message' => 'Personal information created successfully.',
            'data' => json_decode($personalInformationJson, true),
        ]);
    }
}
