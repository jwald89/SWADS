<?php

use Carbon\Carbon;
use App\Models\Office;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\OfficeResource;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

Route::group([
    'prefix' => 'liaison',
    'middleware' => [
        EnsureFeaturesAreActive::using('liaison')]
    ],
    function () {

        Route::get('/monitoring/edit/{id}', function ($id) {
            $monitoring = Monitoring::with(['user', 'assistance', 'intake'])->findOrFail($id);

            $offices = OfficeResource::collection(Office::all());

            return inertia('Liaison/EditLiaison', [
                'monitoring' => $monitoring,
                'offices' => $offices,
            ]);
        });

        Route::put('/monitoring/update/{id}', function(Request $request, $id) {
            $monitoring = Monitoring::with(['user'])->findOrFail($id);

            $monitoring->update(
                array_merge($request->all(),
                [
                    'modified_by' =>  Auth::id(),
                    'modified_date' => Carbon::now()
                ])
            );

            return response()->json(['success' => true]);
        });
});
