<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Municipality::when(request()->search !== '', function($query) {
            return $query->where('municipality', 'like', '%' . request()->search . '%');
        })->paginate(10);

        return inertia('Admin/Municipality', [
            'municipality' => $data,
            'search' => request()->search ?? ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'municipality' => 'required'
        ]);

        $data = Municipality::create($request->all());

        return response()->json($data, 201);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $municipality = Municipality::find($id);

        if (!$municipality) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        return response()->json($municipality, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'municipality' => 'required',
        ]);

        $municipality = Municipality::find($id);

        if (!$municipality) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $municipality->update($request->all());

        return $municipality;
    }

}
