<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Office;
use App\Models\Sector;
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
            $monitoring = Monitoring::with(['user', 'assistance', 'intake', 'sector'])->findOrFail($id);

            $offices = OfficeResource::collection(Office::all());

            $staffAdmin = '';

            // Retrieve the created_by user details
            $createdByUser = null;
            if ($monitoring && $monitoring->created_by !== null) {
                $createdByUser = User::find($monitoring->created_by);
            }

            if ($createdByUser) {
                $staffAdmin = ucwords($createdByUser->first_name) . ' '
                    . ucfirst(substr($createdByUser->middle_init ?? '', 0, 1)) . '. '
                    . ucfirst($createdByUser->last_name);
            }

            return inertia('Liaison/EditLiaison', [
                'monitoring' => $monitoring,
                'offices' => $offices,
                'staff' => $staffAdmin
            ]);
        });

        Route::put('/monitoring/update/{id}', function(Request $request, $id) {
            $monitoring = Monitoring::with(['user'])->findOrFail($id);

            $monitoring->update(
                [
                    'modified_by' =>  Auth::id(),
                    'modified_date' => Carbon::now(),
                    'status_date' => $request->status_date,
                    'remarks' => $request->remarks,
                    'status' => $request->status
                ]);

            return response()->json(['success' => true]);
        });
});
