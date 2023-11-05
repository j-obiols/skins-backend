<?php

namespace App\Http\Resources;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\Skin;


class UserSkinsResource extends JsonResource
{

    function __construct(Skin $model){
    
        parent::__construct($model);

    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $skinData =  $this -> getAvailableSkinData();

        if(!$skinData){
            throw new HttpResponseException(response()->json(['message' => 'Sorry, some data can not be found.'], 404));
        }

        return [
            'id'  => $this -> id,
            'code' => $skinData['code'],
            'name' => $skinData['name'],
            'type' => $skinData['type'],
            'price' => $skinData['price'],
            'colors' => $skinData['colors'],
            'gadget' => $skinData['gadget'],
            'available' => $skinData['available'],
            'active' => $this -> active,
            'colorstatus' => $this -> colorstatus,
            'gadgetstatus' => $this -> gadgetstatus,
            
        ];
    }
}
