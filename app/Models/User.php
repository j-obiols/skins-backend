<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\PaymentMailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Skin;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'nickname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function skins()
    {

       return $this -> hasMany(Skin::class);
       
    }


    public function getEmail() 
    {
        return $this -> email;
    }

    public function getNickname() 
    {
        return $this -> nickname;
    }


    public function sendPaymentEmail($skinName, $price) 
    {
        $clientEmail = $this -> getEmail();
        $nickname = $this -> getNickname(); 

        Mail::to($clientEmail)->send(new PaymentMailable($nickname, $skinName, $price));
    }


} 