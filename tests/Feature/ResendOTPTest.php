<?php

namespace Tests\Feature;

use App\Notifications\OTPNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class ResendOTPTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_resend_otp(){

        $user = $this->logInUser();

        $this->post('/verifyOTP', ['otp'=>'000000'])->assertStatus(302);

        $this->get('/resendOTP')
            ->assertRedirect('/verifyOTP');

        $this->post('/verifyOTP', ['otp'=>$user->otp()])->assertStatus(302);

    }

    /** @test */
    public function a_user_get_new_otp_once_resending(){

        // Given a user login with email and password
        $user = $this->logInUser();
        Notification::fake();

        // When a user click resend link
        $this->get('/resendOTP');

        // Then a user recieve a new OTP
        Notification::assertSentTo($user, OTPNotification::class);

    }
}
