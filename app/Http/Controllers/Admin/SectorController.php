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

        return inertia('Admin/Sector', [
            'sectors' => $sectors,
            'search' => request()->search ?? ''
        ]);
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
     * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        $sectors = Sector::find($id);

        if (!$sectors) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        return response()->json($sectors, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $sectors = Sector::find($id);

        if (!$sectors) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $sectors->update($request->all());

        return $sectors;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
