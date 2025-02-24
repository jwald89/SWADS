<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\ChildDevelopment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChildDevRequest;
use App\Http\Resources\BarangayResource;
use App\Http\Resources\MunicipalityResource;

class ChildDevelopmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $childData = ChildDevelopment::with(['brgy', 'municipal'])
                    ->when(request()->search !== '', function ($query) {
                        $search = request()->search;
                        $query->where('cdc_name', 'like', '%' . $search . '%')
                                ->orWhere('cdw_name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        $barangays = BarangayResource::collection(Barangay::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());

        return inertia('ChildDevelopmentIndex', [
            'childData' => $childData,
            'barangays' => $barangays,
            'municipalities' => $municipalities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangays = BarangayResource::collection(Barangay::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());

        return inertia('ChildDevelopmentCreate', [
            'barangays' => $barangays,
            'municipalities' => $municipalities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChildDevRequest $request)
    {
        $userId = Auth::id();

        $childData = ChildDevelopment::create(
            array_merge($request->all(), ['created_by' => $userId])
        );

        return response()->json($childData, 201);
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
        $childData = ChildDevelopment::with(['brgy', 'municipal'])->findOrFail($id);

        $barangays = BarangayResource::collection(Barangay::all());
        $municipalities = MunicipalityResource::collection(Municipality::all());

        return inertia('ChildDevelopmentEdit', [
            'childData' => $childData,
            'barangays' => $barangays,
            'municipalities' => $municipalities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChildDevRequest $request, string $id)
    {
        $childData = ChildDevelopment::findOrFail($id);

        $childData->update(
            array_merge($request->all(),
            [
                'modified_by' =>  Auth::id(),
                'modified_date' => Carbon::now()
            ])
        );

        return response()->json(['success' => true]);
    }

     /**
     * Filter the specified assistance, municipality, month and year
     */
    public function filter($brgyId = '*', $municipalId = '*', $month = '*')
    {
        $data = ChildDevelopment::with(['municipal', 'brgy']);

        if ($brgyId !== '*') {
            $data->where('barangay', $brgyId);
        }

        if ($municipalId !== '*') {
            $data->where('municipality', $municipalId);
        }

        if ($month !== '*') {
            $data->whereMonth('validity_of_cor', $month);
        }

        return response()->json($data->get());
    }
}
