<?php

namespace App\Http\Middleware;

use App\Models\PersonalInformation;
use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateClientRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve client data from request
        $lastName = $request->input('last_name');
        $firstName = $request->input('first_name');
        $middleName = $request->input('middle_name');
        $birthdate = $request->input('birthdate');
        $currentDate = Carbon::now();
 
        // Check if client exists in the database
        $existingClient = PersonalInformation::where('last_name', $lastName)
            ->where('first_name', $firstName)
            ->where('middle_name', $middleName)
            ->where('birthdate', $birthdate)
            ->orderBy('date_intake', 'desc')
            ->first();

        // If client exists, check the date_intake
        if ($existingClient) {
            $dateCreated = Carbon::parse($existingClient->date_intake);
            $sixMonthsAgo = $currentDate->subMonths(6);

            if ($dateCreated > $sixMonthsAgo) {
                return response()->json([
                    'error' => 'A record for this client already exists within the last 6 months.'
                ], 422);
            }
        }

        return $next($request);
    }
}
