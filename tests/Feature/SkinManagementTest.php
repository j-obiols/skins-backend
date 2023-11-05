<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Skin;
use App\Models\User;


class SkinManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_list_of_available_skins_can_be_retrieved(): void
    {
        $response = $this->get('/api/skins/available');

        $response->assertStatus(200);
    }


    /** @test */
    public function a_registered_user_can_buy_a_skin(): void
    {
        $user = User::create([
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->post('api/login', [
            'email' => 'frank@mail.mail',
            'password'=>'12341234',
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->post('/api/skins/buy',[
            'code' => 28332
        ]);

        $response->assertStatus(200);
    }


    /** @test */
    public function a_registered_user_cannot_buy_twice_the_same_skin(): void
    {
        $user = User::create([
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->post('api/login', [
            'email' => 'frank@mail.mail',
            'password'=>'12341234',
        ]);

        $this->assertAuthenticatedAs($user);

        $this->actingAs($user, 'api');

        $response1 = $this->withHeaders(['Accept'=> 'application/json'])->post('/api/skins/buy',[
            'code' => 28332
        ]);

        $response1->assertStatus(200);

        $response2 = $this->withHeaders(['Accept'=> 'application/json'])->post('/api/skins/buy',[
            'code' => 28332
        ]);

        $response2->assertStatus(200);

        $response2->assertJson([
            'result' => [
                'message' => "You already own this skin. You can choose another one!"
            ],
            'status'=> 200
        ]);
    }


    /** @test */
    public function a_registered_user_cannot_buy_a_skin_if_not_available(): void
    {
        $user = User::create([
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->post('api/login', [
            'email' => 'frank@mail.mail',
            'password'=>'12341234',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->post('/api/skins/buy',[
            'code' => 16548
        ]);
        $response->assertStatus(200);
    }


    /** @test */
    public function a_registered_user_cannot_buy_a_skin_if_code_is_not_provided(): void
    {
        $user = User::create([
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->post('api/login', [
            'email' => 'frank@mail.mail',
            'password'=>'12341234',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->post('/api/skins/buy',[
            'code' => null
        ]);

        $response->assertJson([
            'result' => [
                'message' => "Invalid request."
            ],
            'status'=> 400
        ]);
    }


    /** @test */
    public function a_registered_user_can_see_his_skins(): void
    {
        $user = User::create([
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->post('api/login', [
            'email' => 'frank@mail.mail',
            'password'=>'12341234',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('/api/skins/myskins');
        $response->assertStatus(200);
    }

    



    /** @test */
    public function a_registered_user_can_delete_his_skin(): void
    {
        $user = User::create([
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->post('api/login', [
            'email' => 'frank@mail.mail',
            'password'=>'12341234',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->actingAs($user, 'api');
        
        $skin = Skin::create([
            'code' => 12345,
            'user_id' => $user->id,
            'paid'=> false,
            'active'=> false,
            'colorstatus'=> 'white',
            'gadgetstatus'=> false,
        ]);

        $response = $this->withHeaders(['Accept'=> 'application/json'])->delete('api/skins/delete/'.$skin->id);

        $response->assertJson([
            'result' => [
                'message' => "Your skin was successfully deleted!"
            ],
            'status'=> 200
        ]);

        $this -> assertCount(0, Skin::all());
    }


    /** @test */
    public function a_registered_user_can_see_one_of_his_skins(): void
    {
        $user = User::create([
            'email' => 'frank@mail.mail',
            'nickname' => 'Frank',
            'password'=>'12341234',
            'password_confirmation'=>'12341234',
        ]);

        $this->post('api/login', [
            'email' => 'frank@mail.mail',
            'password'=>'12341234',
        ]);

        $skin = Skin::create([
            'code' => 12345,
            'user_id' => $user->id,
            'paid'=> false,
            'active'=> false,
            'colorstatus'=> 'white',
            'gadgetstatus'=> false,
        ]);

        $this->assertAuthenticatedAs($user);
        $this->actingAs($user, 'api');

        $response = $this->withHeaders(['Accept'=> 'application/json'])->get('api/skin/getskin/'.$skin->id);
        $this -> assertCount(1, Skin::all());
        $response->assertJson([
            'status'=> 200
        ]);
    }

} 