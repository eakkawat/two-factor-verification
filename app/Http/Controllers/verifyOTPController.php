<?php

namespace App\Http\Controllers;

use App\Http\Requests\OTPRequest;

class verifyOTPController extends Controller
{

    public function show(){
        return view('otp.show');
    }


    public function verify(OTPRequest $request){

        if(strval($request->otp) === strval(auth()->user()->otp())) {

            auth()->user()->update(['is_verified'=>true]);

            return redirect('/home');
        }

        return redirect()->back()->withErrors(['otp'=>'OTP does not match or expired.']);
        
    }

    public function resend(){
        if(auth()->check()){
            auth()->user()->resendOTP();
            return redirect('/verifyOTP');
        }

        return redirect()->back();
    }
}
