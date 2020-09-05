<?php

namespace Tests\Feature;

use App\Mail\OTPMail;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_otp_email_is_sent_once_user_logged_in(){

        Mail::fake();

        $user = factory(User::class)->create();

        $response = $this->post('/login',['email'=>$user->email, 'password'=>'password']);

        Mail::assertSent(OTPMail::class);

    }

    /** @test */
    public function an_otp_email_is_not_sent_if_credentials_is_incorrect(){

        $this->withExceptionHandling();

        Mail::fake();

        $user = factory(User::class)->create();

        $response = $this->post('/login',['email'=>$user->email, 'password'=>'asdf']);

        Mail::assertNotSent(OTPMail::class);

    }

    /** @test */
    public function otp_is_stored_in_cache_for_user(){

        $user = factory(User::class)->create();

        $response = $this->post('/login', ['email'=>$user->email, 'password'=>'password']);

        $this->assertNotNull($user->otp());
        
    }
}
