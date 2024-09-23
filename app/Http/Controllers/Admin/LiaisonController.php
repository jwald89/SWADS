<?php

namespace App\Http\Controllers\Admin;

use App\Models\Liaison;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiaisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Liaison::get();

        return inertia('Liaison', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('CreateLiaison');
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

        $data = Liaison::create($request->all());

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
