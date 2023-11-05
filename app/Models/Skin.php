<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use Illuminate\Support\Facades\Storage;

class Skin extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'paid',
        'active',
        'colorstatus',
        'gadgetstatus',
        'user_id'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        
    ];

    
    static function readJson(): array
    {
        $allSkins = Storage::json('/public/skins.json');

        return $allSkins;
    }


    static function getAvailableSkins(array $allSkins)
    {
        $availableSkins = array();

        foreach($allSkins as $skin){
            if($skin['available'] == true){
                array_push($availableSkins, $skin);
            }
        }

        return $availableSkins;
    }


    static function getAvailableSkinByCode($code)
    {
        $allSkins = Skin::readJson();

        $availableSkins = Skin::getAvailableSkins($allSkins);

        $codes = array_column($availableSkins, 'code');

        if(in_array($code, $codes)){

            $key = array_search($code, $codes);

            $skin =  $availableSkins[$key];

            return $skin;

        } else {
            return false;
        }
         
    }

    
    static function checkUniqueCode(array $allSkins)
    {
         
        $codeColumn = array_column($allSkins, 'code');
    
        if (count($codeColumn) > count(array_unique($codeColumn))) {
    
            return false;
        }
    
        return  true;
          
    }


    static function checkValidPrice(array $allSkins)
    {
         
        $prices = array_column($allSkins, 'price');
    
        foreach($prices as $price){
            if(!is_int($price) or $price = null){
                return false;
            } 
        }
    
        return  true;     
    }
    

    static function checkValidNames(array $allSkins)
    {
         
        $names = array_column($allSkins, 'name');
    
        foreach($names as $name){
            if(!is_string($name) or strlen($name) < 3){
                return false;
            } 
        }
    
        return  true;
          
    }

    
    static function checkUniqueName(array $allSkins)
    {
         
        $nameColumn = array_column($allSkins, 'name');
    
        if (count($nameColumn) > count(array_unique($nameColumn))) {
    
            return false;
        }
    
        return  true;
          
    }


    static function checkColors(array $allSkins)
    {
        $colorsColumn = array_column($allSkins, 'colors');

        foreach($colorsColumn as $colors){
            if(!is_array($colors)){
                return false;
                break;
            }
        }

        return true;   
    }


    static function checkData(array $allSkins)
    {
        /* Other validation methods could be added here... */
        $checkCodes = Skin::checkUniqueCode($allSkins);
        $checkValidPrice = Skin::checkValidPrice($allSkins);
        $validNames = Skin::checkValidNames($allSkins);
        $checkUniqueName = Skin::checkUniqueName($allSkins);
        $checkColors = Skin::checkColors($allSkins);
       
        if(!$checkCodes or !$checkValidPrice or !$validNames or !$checkUniqueName or !$checkColors) {
            return false;
        }
    
        return true;
    }


    public function user()
    {
        return $this -> belongsTo(User::class);
    }


    public function getAvailableSkinData()
    {
        
        $code = $this -> code;

        $allSkins = Storage::json('/public/skins.json');

        $availableSkins = Skin::getAvailableSkins($allSkins);

        $key = array_search($code, array_column($availableSkins, 'code'));
        
        $skinData =  $availableSkins[$key];
         
        return  $skinData;

    }


    /*This function will only be available for admin role in a next version:*/
    public function setIsPaid()
    {
        $this -> isPaid = true;
    }


    /*This function will only be available for admin role in a next version:*/
    public function getIsPaid()
    {
        return $this -> isPaid;
    }


    /*This function will only be available for admin role in a next version:*/
    public function activateSkin()
    { 
        if($this -> getIsPaid) {
            $this -> active = true;
            return true;
        } else {
            return false;
        }
    }


    /*This function will only be available for admin role in a next version:*/
    public function blockSkin()
    {
        $this -> active = false;
    }


    public function setColor($color) 
    {  
        $ok = $this -> colorstatus = $color;
        
        if($ok) {
           return true;
        } else {
            return false;
        }
    }


    public function setGadgetStatus($status) {
        
        $this -> gadgetstatus = $status;
       
    }


    public function changeGadgetStatus($status) {

        switch ($status){
            case false:
               $this -> setGadgetStatus(true);
               break;
            case true:
                $this  -> setGadgetStatus(false);
                break;
        }

        $this  -> save();
        return true;
    }  

} 