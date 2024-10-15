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

        return inertia('Municipality', [
            'municipality' => $data,
            'search' => request()->search ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('CreateMunicipality');
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
