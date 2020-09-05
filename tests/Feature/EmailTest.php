<?php

namespace Tests\Feature;

use App\Notifications\OTPNotification;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setup(): void{
        parent::setup();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function an_otp_email_is_sent_once_user_logged_in(){

        Notification::fake();

        $response = $this->post('/login',['email'=>$this->user->email, 'password'=>'password']);

        Notification::assertSentTo($this->user, OTPNotification::class);

    }

    /** @test */
    public function an_otp_email_is_not_sent_if_credentials_is_incorrect(){

        $this->withExceptionHandling();

        Notification::fake();

        $response = $this->post('/login',['email'=>$this->user->email, 'password'=>'asdf']);

        Notification::assertNotSentTo($this->user, OTPNotification::class);

    }

    /** @test */
    public function otp_is_stored_in_cache_for_user(){

        $response = $this->post('/login', ['email'=>$this->user->email, 'password'=>'password']);

        $this->assertNotNull($this->user->otp());
        
    }
}
