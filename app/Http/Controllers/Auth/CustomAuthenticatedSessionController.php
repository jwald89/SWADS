<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomAuthenticatedSessionController extends Controller
{
    public function destroy(Request $request)
    {
        Log::info('User logged out: ' . auth()->user()->username);

        Auth::logout();

        return response()->json(['success' => true]);

    }
}
