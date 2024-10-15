<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sectors = Sector::when(request()->search !== '', function($query) {
            return $query->where('name', 'like', '%' . request()->search . '%');
        })->orderBy('created_at', 'DESC')
        ->paginate(10);

        return inertia('Sector', [
            'sectors' => $sectors,
            'search' => request()->search ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('CreateSector');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = Sector::create($request->all());

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
