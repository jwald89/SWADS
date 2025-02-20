<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barangay;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MunicipalityResource;
use Illuminate\Support\Testing\Fakes\BatchFake;

class BarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangays = Barangay::with(['municipal'])
                    ->when(request()->search !== '', function($query){
                        return $query->whereAny([
                            'barangay',
                        ],
                        'like', '%' . request()->search . '%');
                    })->orderBy('created_at', 'DESC')
                    ->paginate(10);

        return inertia('Admin/Barangay', [
            'barangay' => $barangays,
            'search' => request()->search ?? ''
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'municipality_id' => 'required',
            'barangay' => 'required'
        ]);

        $data = Barangay::create($request->all());

        return response()->json($data, 201);
    }

}
