<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AssistanceType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $assistance->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return $assistance;
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
     {
         $data = AssistanceType::find($id);

         $data->delete();

         return response()->json(['success' => true]);
     }
}
