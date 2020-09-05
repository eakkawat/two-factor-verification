<?php

namespace App;

use App\Mail\OTPMail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean'
    ];


    public function otp(){
        return Cache::get($this->OTPkey());
    }

    public function OTPkey(){
        return "otp_for_{$this->id}";
    }

    public function cacheTheOTP(){
        $otp = rand(100000, 999999);
        Cache::put([$this->OTPkey() => $otp], now()->addSeconds(20));
    }

    public function sendOTP(){
        $this->cacheTheOTP();
        Mail::to('eak@gmail.com')->send(new OTPMail($this->otp()));
    }

    public function resendOTP(){
        Cache::forget($this->otp());
        $this->sendOTP();
    }
    
}
