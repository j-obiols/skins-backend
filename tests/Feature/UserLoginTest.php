<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_correct_credentials() {

        $user = User::create([
            'email'=>'auth@mail.mail',
            'nickname'=>'Authenticated',
            'password'=>bcrypt($password='password')
        ]);

        $response =  $this->post('api/login', [
           'email' => 'auth@mail.mail',
           'password' => $password
        ]);

       $this->assertAuthenticatedAs($user);

    }
} 