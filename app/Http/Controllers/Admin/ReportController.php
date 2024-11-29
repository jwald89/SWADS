<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function intakeSheetServed()
    {
        return inertia('Reports/IntakeSheetsServed');
    }


    public function perMunicipality()
    {
        return inertia('Reports/PerMunicipality');
    }


    public function servedPerSectoral()
    {
        return inertia('Reports/ServedPerSectoral');
    }

    public function perSectoral()
    {
        return inertia('Reports/PerSectoral');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
