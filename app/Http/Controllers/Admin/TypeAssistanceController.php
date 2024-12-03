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
        })->paginate(10);

        return inertia('Admin/TypeAssistance', [
            'assistanceType' => $assistanceType,
            'search' => request()->search ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/CreateTypeAssistance');
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
