<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

    public function index(){

        return User::all();

    }

    
    public function register(RegisterUserRequest $request)
    {
        
        $user = User::create([
            'email' => $request['email'],
            'nickname'=>ucfirst(strtolower($request['nickname'])),
            'password' => bcrypt($request['password'])
        ]);

        if(!$user){
            throw new HttpResponseException(response()->json(['message' => 'Something went wrong. Please try again.'], 404));
        } 
        
        return response()->json([
            'result' => [
                'message' => 'User created succesfully.'
            ],
            'status' => 200
        ]);
       

    }

    
    public function login(LoginUserRequest $request) 
    {
        $credentials = [
            'email' => $request -> email,
            'password' => $request -> password
        ];

        if(!Auth::attempt($credentials)) {
            return response()->json (['message'=>'Invalid login credentials.'], 401);
        }
       
        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();

        $accessToken = $user->createToken('authToken')->accessToken;

        if(!$user or !$accessToken){
            throw new HttpResponseException(response()->json(['message' => 'Something went wrong. Please try again.'], 404));
        }

        return response()->json([
            'data' => [
                'nickname' => $user->nickname,
                'email' => $user->email,
                'token' => $accessToken
            ],
            'status' => 200
        ]);
    }


    public function logout(Request $request) {

        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();

        $logout = $user -> token()->revoke();

        if(!$logout){
            throw new HttpResponseException(response()->json(['message' => 'Something went wrong. Please try again.'], 404));
        }

        return response()->json([
            'message' => 'Logged out successfully.',
            'status' => 200
        ]);

    }
    
} 