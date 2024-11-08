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

        return inertia('StaffAdmin', [
            'staff' => $data,
            'search' => request()->search ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('CreateStaff');
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
