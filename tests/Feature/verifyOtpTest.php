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

        // Given a user login to the form and OTP is sent
        $user = factory(User::class)->create();
        $this->post('/login', ['email'=>$user->email, 'password'=>'password']);

        // When a user submit a correct otp
        $this->post('/verifyOTP', ['otp'=>$user->otp()])->assertStatus(302);

        // Then a user get verified
        $this->assertDatabaseHas('users', ['email'=> $user->email, 'is_verified' => true]);
    }

    /** @test */
    public function a_user_can_see_verify_page(){

        $this->logInUser();

        $this->get('/verifyOTP')
            ->assertStatus(200)
            ->assertSee('Enter OTP');

    }


    /** @test */
    public function invalid_otp_return_errors_message(){

        // Given a user input email and password
        $this->logInUser();

        // When input invalid otp
        $res = $this->post('/verifyOTP', ['otp' => 'invalid']);

        // Then return invalid otp error
        $res->assertSessionHasErrors();
        
        
    }

    /** @test */
    public function if_no_otp_is_given_returns_error(){

        $this->withExceptionHandling();
        // Given a user input email and password
        $this->logInUser();

        // When input invalid otp
        $res = $this->post('/verifyOTP', ['otp' => '']);

        // Then return invalid otp error
        $res->assertSessionHasErrors([
            'otp' => 'The otp field is required.'
        ]);
        
        
    }
}
