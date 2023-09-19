<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propertie;

class SearchController extends Controller
{
    //
    public function search(Request $request){
        // $properties = Propertie::all();
        $query = Propertie::query();

        $world = $request -> input('world');
        $city = $request -> input('city');
        $type = $request -> input('type');
        $status = $request -> input('status');

        if($world){
            $query -> where('propertyName', 'like', "%{$world}%");
        }
        if($status){
            $query -> where('propertyStatus', '=', $status);
        }
        if($type){
            $query -> where('propertyType', '=', $type);
        }
        if($city){
            // $properties = $properties -> where('city', '=',  $city);
            $query -> where('city',  "like","%{$city}%");
        }

        
        // $properties = $query::orderBy('create_at','DESC') -> get();
        $properties = $query -> get();

        // $properties = json_decode($properties);
        
        foreach ($properties as $property) {
            $property['images'] = json_decode($property['images']);
        }



        return response() -> json($properties);
    }



}
