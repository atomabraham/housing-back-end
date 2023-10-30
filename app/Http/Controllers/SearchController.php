<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propertie;

class SearchController extends Controller
{
    //
    public function search(Request $request){
        // $properties = Propertie::all();
        $query = Propertie::query()  -> where('active', '=','true') ->where('vendu','=','false') ->where('reserver','=','false');;

        $world = $request -> input('world');
        $city = $request -> input('city');
        $type = $request -> input('type');
        $status = $request -> input('status');

        if($world){
            $query -> where('propertyName', 'like', "%{$world}%") -> where('active', '=','true') ->where('vendu','=','false') ->where('reserver','=','false');
        }
        if($status){
            $query -> where('propertyStatus', '=', $status) -> where('active', '=','true') ->where('vendu','=','false') ->where('reserver','false');
        }
        if($type){
            $query -> where('propertyType', '=', $type) -> where('active', '=','true') ->where('vendu','false') ->where('reserver','=','false');
        }
        if($city){
            // $properties = $properties -> where('city', '=',  $city);
            $query -> where('city',  "like","%{$city}%") -> where('active', '=','true') ->where('vendu','=','false') ->where('reserver','=','false');
        }

        $properties = $query -> get();

        // $properties = $query->paginate(4); // 10 annonces par page


        foreach ($properties as $property) {
            $property['images'] = json_decode($property['images']);
        }



        return response() -> json($properties);

        // return response()->json([
        //     'data' => $properties->items(),
        //     'current_page' => $properties->currentPage(),
        //     'last_page' => $properties->lastPage()
        // ]);
    }



}
