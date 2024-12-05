<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssistanceType;
use Illuminate\Http\Request;

class TypeAssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assistanceType = AssistanceType::when(request()->search !== '', function($query) {
            return $query->where('name', 'like', '%' . request()->search . '%');
        })
        ->orderByDesc("created_at")
        ->paginate(10);

        return inertia('Admin/TypeAssistance', [
            'assistanceType' => $assistanceType,
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

        $data = AssistanceType::create($request->all());

        return response()->json($data, 201);
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        $assistance = AssistanceType::find($id);

        if (!$assistance) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        return response()->json($assistance, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $assistance = AssistanceType::find($id);

        if (!$assistance) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $assistance->update($request->all());

        return $assistance;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
