<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class verifyOtpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_submit_otp_then_get_verified(){

        $this->withoutExceptionHandling();

        // Given a user login to the form
        $user = factory(User::class)->create();
        $this->post('/login', ['email'=>$user->email, 'password'=>'password']);

        // When a user submit a correct otp
        $otp = $user->otp();
        $this->post('/verifyOTP', ['otp'=>$otp])->assertStatus(201);

        // Then a user get verified
        $this->assertDatabaseHas('users', ['email'=> $user->email, 'is_verified' => true]);
    }
}
