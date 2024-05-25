<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CivilStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\IntakeRequest;
use App\Http\Resources\AssistanceResource;
use App\Models\AssistanceType;
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

        return inertia('IntakeCreate', [
            'assistances' => $assistances,
            'civilStatus' => CivilStatus::names()
        ]);
    }

    public function store(IntakeRequest $request)
    {
        dd($request);
    }
}
