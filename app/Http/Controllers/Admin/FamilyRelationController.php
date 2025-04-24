<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\FamRelationship;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FamilyRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $relationship = FamRelationship::when(request()->search !== '', function($query){
            return $query->where('name', 'like', '%' . request()->search . '%');
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10);

        return inertia('Admin/FamilyRelation', [
            'relationship' => $relationship,
            'search' => $request->search ?? ''
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

        $data = FamRelationship::create($request->all());

        return response()->json($data, 201);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $relationships = FamRelationship::find($id);

        if(!$relationships){
            return response()->json(['error' => 'Record not found.'], 404);
        }

        return response()->json($relationships, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = FamRelationship::find($id);

        if (!$data) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $data->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return $data;
    }

}
