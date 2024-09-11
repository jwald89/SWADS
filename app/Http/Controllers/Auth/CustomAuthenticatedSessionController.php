<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomAuthenticatedSessionController extends Controller
{
    public function destroy(Request $request)
    {
        \Log::info('User logged out: ' . Auth::user()->username);

        Auth::logout();

        return response()->json(['success' => true]);

    }
}
