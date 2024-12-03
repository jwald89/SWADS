<?php

namespace App\Http\Controllers\Admin;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfficeChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Office::when(request()->search !== "", function($query) {
            return $query->whereAny([
                'acronym',
                'description'
            ], 'like', '%' . request()->search . '%');
        })->orderBy('created_at', 'DESC')
        ->paginate(10);

        return inertia('Admin/OfficeCharges', [
            'offices' => $offices,
            'search' => request()->saerch ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/CreateOffice');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'acronym' => 'required',
            'description' => 'required',
        ]);

        $data = Office::create($request->all());

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
