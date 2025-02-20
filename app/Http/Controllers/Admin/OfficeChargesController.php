<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OfficeChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Office::when(request()->search !== "", function($query) {
            return $query->whereAny([
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'title' => 'required',
        ]);

        $data = Office::create($request->all());

        return response()->json($data, 201);
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        $officeCharge = Office::find($id);

        if (!$officeCharge) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        return response()->json($officeCharge, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required',
        ]);

        $officeCharge = Office::find($id);

        if (!$officeCharge) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $officeCharge->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return $officeCharge;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Office::find($id);

        $data->delete();

        return response()->json(['success' => true]);
    }
}
