<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class loginTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function after_login_user_still_cannot_access_homepage_until_verified(){

        $user = factory(User::class)->create();
        
        $this->actingAs($user);

        $this->get('/home')->assertRedirect('/verifyOTP');
        
    }

    /** @test */
    public function after_login_user_can_access_homepage_if_verified(){

        // Given there is a user login to the system
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // When user is verified 
        $user->is_verified = true;
        $user->save();

        // Then user can access home page
        $response = $this->get('/home');
        $response->assertStatus(200);
        
    }
}
