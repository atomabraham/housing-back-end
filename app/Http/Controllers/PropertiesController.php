<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Propertie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Propertie::all();

        // Décoder le champ "images" pour chaque propriété
        foreach ($properties as $property) {
            $property->images = json_decode($property->images);
        }

        return response() -> json($properties,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'propertyName' => 'required',
            'propertyType' => 'required',
            'propertyStatus' => 'required',
            'price' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'description' => 'required',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'contactName' => 'required',
            'contactEmail' => 'required',
            'contactPhone' => 'required',
            'agrement' => 'required',
            'contactPhone' => 'required',
        ]);

        try {
            // enregistrement d'une propriete
            $property = new Propertie();
            $photos = [];


            foreach($request->file('images') as $photo) {
                $path = $photo->store('images/properties', 'public');
                $photos[] = $path;
            }


            $property->propertyName = $request -> input('propertyName');
            $property->propertyType = $request -> input('propertyType');
            $property->propertyStatus = $request -> input('propertyStatus');
            $property->bedrooms = $request -> input('bedrooms');
            $property->bathrooms = $request -> input('bathrooms');
            $property->area = $request -> input('area');
            $property->price = $request -> input('price');
            $property->country = $request -> input('country');
            $property->city = $request -> input('city');
            $property->quartier = $request -> input('quartier');
            $property->postalcode = $request -> input('postalcode');
            $property->description = $request -> input('description');
            $property->agrement = $request -> input('agrement');
            $property->images = json_encode($photos);
            $property->contactName = $request -> input('contactName');
            $property->contactEmail = $request -> input('contactEmail');
            $property->contactPhone = $request -> input('contactPhone');

            $property->save();


            return response()->json([
                'message'=>'Property Created Successfully!!'
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while creating a property!!'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Propertie $property, $id)
    {
        $property = Propertie :: where ('id', $id) -> get();

        $property = json_decode($property);

        $property[0] -> images = json_decode($property[0] -> images);

        $property[0] -> agrement = json_decode($property[0] -> agrement);

        return response() -> json ($property);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Propertie $property)
    {
        //
        try{
            $property = Propertie::where('id',$id);
            // dd($property -> propertyName);
            // $images []= $property -> images;
            // if(count($images) > 0){
            //     foreach ($property -> images as $image) {
            //         $exist = Storage::disk('public') -> exists("{$images}");
            //         if($exist){
            //             Storage::disk('public') -> delete("{$image}");
            //         }
            //     }
            // }
            // $property -> delete();

            // return response() -> json($property);

            // echo($property->contactPhone);

        }catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while deleting a product!!'
            ]);
        }
    }
}
