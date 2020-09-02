<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class verifyOTPController extends Controller
{
    public function verify(Request $request){
        $validated = $request->validate([
            'otp' => 'required'
        ]);

        if(Cache::get('otp') === $validated['otp']) {
            auth()->user()->is_verified = true;
            auth()->user()->save();
        }

        return response()->json([
            'message' => 'verified'
        ], 201);
        
    }
}
