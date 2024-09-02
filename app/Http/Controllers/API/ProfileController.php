<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('can:view-profile');
    }
    
    
    public function profile(Request $request)
    {
        // Get authenticated user and load roles if necessary
        $user = $request->user()->load('roles');
        return response()->json($user);
    }
}
