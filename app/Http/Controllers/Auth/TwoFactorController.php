<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TwoFactorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(){
        return view('auth.twofactor');
    }

    public function store(Request $request){
        $request->validate([
            'two_factor_code' => 'required|integer'
        ]);

        if($request->two_factor_code === auth()->user()->two_factor_code){
            auth()->user()->verified();
            auth()->user()->resetTwoFactorCode();
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['two_factor_code' => 'The code you enter does not match.']);
    }

    public function resend(){
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
    }
}
