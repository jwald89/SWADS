<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffAdministered;
use Illuminate\Http\Request;

class StaffAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = StaffAdministered::when(request()->search !== "", function($query) {
            return $query->whereAny([
                'firstname',
                'middlename',
                'lastname',
            ],
            'like', '%' . request()->search . '%')
                ->orWhereRaw("CONCAT(firstname, ' ', middlename) like ?", ['%' . request()->search . '%'])
                ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ['%' . request()->search . '%'])
                ->orWhereRaw("CONCAT(firstname, ' ', middlename, ' ', lastname) like ?", ['%' . request()->search . '%']);
                })->orderBy('created_at', 'DESC')
            ->paginate(10);

        return inertia('Admin/StaffAdmin', [
            'staff' => $data,
            'search' => request()->search ?? ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'middlename' => 'required'
        ]);

        $data = StaffAdministered::create($request->all());

        return response()->json($data, 201);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $staff = StaffAdministered::find($id);

        if (!$staff) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        return response()->json($staff, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'middlename' => 'required'
        ]);

        $staff = StaffAdministered::find($id);

        if (!$staff) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $staff->update($request->all());

        return $staff;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
