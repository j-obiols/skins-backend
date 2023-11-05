<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserRegisterTest extends TestCase
{
    
    use RefreshDatabase; 
    

    /** @test */
    public function a_user_can_be_registered()
    {
        
        $this -> withoutExceptionHandling();

        $response = $this->post('api/register', [
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, User::all());

        $user = User::first();
        $this -> assertEquals($user->nickname, 'Frank');
        $this -> assertEquals($user->email, 'frank@mail.mail');
    
    }

    /** @test */
    public function a_user_cannot_be_registered_if_email_is_null() {
    
        $response = $this->post('api/register', [
            'email' => '',
            'nickname' => 'Lionel',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());
        $response->assertStatus(422);

        $response->assertJson([
            'errors' => [
                'email' => ["The email field is required."]
            ]
        ]);
    
    }

    /** @test */
    public function a_user_cannot_be_registered_if_email_is_not_an_email() {
    
        $response = $this->post('api/register', [
            'email' => 'alea.com',
            'nickname' => 'Mina',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());
        $response->assertStatus(422);

        $response->assertJson([
            'errors' => [
                'email' => ["The email field must be a valid email address."]
            ]
        ]);
    
    }

    /** @test */
    public function a_user_cannot_be_registered_if_email_is_not_unique() {
    
        $response1 = $this->post('api/register', [
            'email' => 'leo@mail.mail',
            'nickname' => 'Leox',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $response1->assertStatus(200);

        $response2 = $this->post('api/register', [
            'email' => 'leo@mail.mail',
            'nickname' => 'Leopoldo',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(1, User::all());
        $response2->assertStatus(422);
    
    }


    /** @test */
    public function a_user_cannot_be_registered_if_nickname_is_not_string() {
    
        $response = $this->post('api/register', [
            'email' => 'leo@mail.mail',
            'nickname' => 1234,
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(0, User::all());
        $response->assertStatus(422);
    
    }

    /** @test */
    public function a_user_cannot_be_registered_if_nickname_is_not_unique() {
    
        $response1 = $this->post('api/register', [
            'email' => 'lionel@mail.mail',
            'nickname' => 'Leox',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);
        
        $response1->assertStatus(200);

        $response2 = $this->post('api/register', [
            'email' => 'leo@mail.mail',
            'nickname' => 'Leox',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->assertCount(1, User::all());
        $response2->assertStatus(422);
    
    }

} 