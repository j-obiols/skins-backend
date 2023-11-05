<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception;
use DateTime;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Skin;
use App\Http\Resources\SkinShowResource;
use App\Http\Resources\UserSkinsResource;


class SkinController extends Controller
{
     
    public function availableSkins()
    {
         
        $allSkins = Skin::readJson();
       
        if(!$allSkins){

            throw new HttpResponseException(response()->json(['message' => 'Not found.'], 404));
           
        }

        $validData = Skin::checkData($allSkins);

        if(!$validData) {

            throw new HttpResponseException(response()->json(['message' => 'There is a data problem. Please try it again later.'], 423));
           
        }

        $availableSkins =  Skin::getAvailableSkins($allSkins);

        if(!$availableSkins){

            throw new HttpResponseException(response()->json(['message' => 'Not found.'], 404));
           
        }

        return response()->json([
            'availableSkins' => $availableSkins,
            'status' => 200  
        ]);
       
    }


    public function buy(request $request) 
    {

        /** @var \App\Models\User $user **/
        $user = auth()->user();
        $code = $request -> code;
        $isOwner = DB::table('skins') -> where('user_id', $user->id) -> where('code', $code) ->first();
        $boughtSkin =  Skin::getAvailableSkinByCode($code);


        if(!$code) {

            return response()->json([
                'result' => [
                    'message' => "Invalid request.",
                ],
                'status' => 400  
            ]);

        } elseif($isOwner) {

            return response()->json([
                'result' => [
                    'message' => "You already own this skin. You can choose another one!",
                ],
                'status' => 200  
            ]);
            
        } else if(!$boughtSkin) {

            return response()->json([
                'result' => [
                    'message' => "This skin is not available.",
                ],
                'status' => 200  
            ]);

        } else {

            DB::beginTransaction();

            try {

                $colors = $boughtSkin['colors'];

                $user -> skins() ->create([
                    'code' => $boughtSkin['code'],
                    'paid' => false,
                    'active' => false,
                    'colorstatus' => $colors[0],
                    'gadgetstatus' => true 
                ]);

                $price = $boughtSkin['price'];
                $skinName = $boughtSkin['name'];

                /*A payment mail will be sent: the following code line can be activated and tested, 
                using Mailtrap, and setting .env file's mailing fields according to your account data.*/

                //$user -> sendPaymentEmail($skinName, $price);
                
                DB::commit();
                
            } catch (Exception $exception) {

                DB::rollback();

                throw new HttpResponseException(response()->json([
                    'message' => 'The purchase process could not be completed.'], 
                    202)
                );
                //Or, to retrieve more details about exception:
                //return response()->json(['message' => $exception->getMessage()],404);
            }
            
        }
    

        return response()->json([
            'result' => [
                'message' => "Your new Skin is ready! We've sent you an email payment link.",
            ],
            'status' => 200  
        ]);
        
    }


    public function getSkins(){

        /** @var \App\Models\User $user **/
        $user = auth()->user();

        $userSkins = $user -> skins() ->get();
        
        return response()->json(['userSkins' => UserSkinsResource::collection($userSkins)]);
        
    }


    public function show($id){

        /** @var \App\Models\User $user **/
        $user = auth()->user();

        $skin = $user -> skins() ->where('id', $id) ->first();

        if(!$skin){
            throw new HttpResponseException(response()->json([
                'message' => 'Skin not found.'], 
                404)
            );
        }

        return response()->json([
            'data' => SkinShowResource::make($skin),
            'status' => 200,
        ]);

    }
    

    public function destroy($id) {

        /** @var \App\Models\User $user **/
        $user = auth()->user();
        
        $skin = DB::table('skins') -> where('id', $id) -> first();

        $deleteAction = DB::table('skins') -> where('id', $id) -> delete();
         
        if(!$skin) {

            return response()->json([
                'result' => [
                    'message' => 'Skin not found.',
                ],
                'status' => 400
            ]);

        } elseif (!$deleteAction){

            return response()->json([
                'result' => [
                    'message' => 'Something went wrong. Pleasy try it again later.',
                ],
                'status' => 400
            ]);

        }
            
        return response()->json([
                'result' => [
                    'message' => "Your skin was successfully deleted!",
                ],
                'status' => 200  
        ]);
   
    }


    public function updateColor(Request $request)
    {

        /** @var \App\Models\User $user **/
        $user = auth()->user();

        $skin = $user -> skins() ->where('code', $request -> code)->first();

        if(!$skin){

            return response()->json([
                'result' => [
                    'message' => 'Skin not found.',
                ],
                'status' => 400
            ]);
        }

        $ok = $skin -> setColor($request -> color);

        if(!$ok) {
            
            throw new HttpResponseException(response()->json([
                'message' => 'Something went wrong. Pleasy try it again later!'], 
                500)
            );

        }

        return response()->json([
            'data' =>  SkinShowResource::make($skin),
            'status' => 200,
        ]);
  
    }


    public function updateGadget(Request $request)
    {

        /** @var \App\Models\User $user **/
        $user = auth()->user();

        $skin = $user -> skins() ->where('code', $request -> code)->first();

        if(!$skin){

            return response()->json([
                'result' => [
                    'message' => 'Skin not found.',
                ],
                'status' => 400
            ]);
        }

        $status = $skin -> gadgetstatus;
        $ok = $skin -> changeGadgetStatus($status);

        if(!$ok) {
            throw new HttpResponseException(response()->json([
                'message' => 'Something went wrong. Pleasy try it again later'], 
                500)
            );

        }

        return response()->json([
            'data' =>  SkinShowResource::make($skin),
            'status' => 200,
        ]);
  
    }
    
} 