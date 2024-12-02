<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke()
    {
        return match (true) {
            auth()->user()->features()->active('liaison') => redirect()->to('/monitoring'),
            auth()->user()->features()->active('municipal') => redirect()->to('/municipal/dashboard'),
            auth()->user()->features()->active('user') => redirect()->to('/user/dashboard'),
            default => redirect()->to('/dashboard'),
        };
    }
}
