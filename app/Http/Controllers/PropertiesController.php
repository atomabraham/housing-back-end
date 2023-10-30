<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Propertie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Psy\Readline\Hoa\Console;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allPropertie()
    {
        $properties = Propertie::orderBy('created_at', 'desc') -> get();

        // Décoder le champ "images" pour chaque propriété
        foreach ($properties as $property) {
            $property->images = json_decode($property->images);
        }

        return response() -> json($properties,200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Propertie::orderBy('created_at', 'desc') -> where('active', 'true') ->where('vendu','false') ->where('reserver','false') -> get();

        // Décoder le champ "images" pour chaque propriété
        foreach ($properties as $property) {
            $property->images = json_decode($property->images);
        }

        return response() -> json($properties,200);
    }

    //recuperation des biens à activer
    public function propertiesToActive (){
        $properties = Propertie::orderBy('created_at', 'desc') -> where('active', 'false') -> get();

        // Décoder le champ "images" pour chaque propriété
        foreach ($properties as $property) {
            $property->images = json_decode($property->images);
        }

        return response() -> json($properties,200);
    }

    //recuperation des biens reserveés
    public function propertiesReserved (){
        $properties = Propertie::orderBy('created_at', 'desc') -> where('reserver', 'true') -> get();

        // Décoder le champ "images" pour chaque propriété
        foreach ($properties as $property) {
            $property->images = json_decode($property->images);
        }

        return response() -> json($properties,200);
    }

    //recuperation des biens vendu
    public function propertiesVendu (){
        $properties = Propertie::orderBy('created_at', 'desc') -> where('vendu', 'true') -> get();

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


            $property->id_user = $request -> input('id_user');
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
    public function update(Request $request, Propertie $property)
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
        // try{

        //     // $property -> update($request -> except('propertyName','propertyType','propertyStatus','price','city','description','contactName','contactEmail','contactPhone'));

        //     // $property->propertyName = $request -> input('propertyName');
        //     // $property->propertyType = $request -> input('propertyType');
        //     // $property->propertyStatus = $request -> input('propertyStatus');
        //     // $property->bedrooms = $request -> input('bedrooms');
        //     // $property->bathrooms = $request -> input('bathrooms');
        //     // $property->area = $request -> input('area');
        //     // $property->price = $request -> input('price');
        //     // $property->country = $request -> input('country');
        //     // $property->city = $request -> input('city');
        //     // $property->quartier = $request -> input('quartier');
        //     // $property->postalcode = $request -> input('postalcode');
        //     // $property->description = $request -> input('description');
        //     // $property->agrement = $request -> input('agrement');

        //     // $property->save();


        //     // return response()->json([
        //     //     'message'=>'Property updated Successfully!!'
        //     // ]);

        // }catch (ValidationException $e) {
        //     return response()->json([
        //         'message' => 'Validation error',
        //         'errors' => $e->errors()
        //     ], 422);
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, string $id)
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
            $property = Propertie::where('id',$id) -> get();
            // dd($property -> propertyName);
            $images []= $property -> images;
            if(count($images) > 0){
                foreach ($property -> images as $image) {
                    $exist = Storage::disk('public') -> exists("{$images}");
                    if($exist){
                        Storage::disk('public') -> delete("{$image}");
                    }
                }
            }
            $property -> delete();
            echo ($property);

            return response() -> json([]);

            // echo($property->contactPhone);

        }catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while deleting a product!!'
            ]);
        }
    }

    //generer les donnees fictives
    public function genererFake()
    {
        $faker = Faker::create();

        $properties = [];

        for ($i = 0; $i < 100; $i++) {
            $property = new Propertie();

            $images = [];

            for ($i = 0; $i < random_int(1, 10); $i++) {
                $imagePath = 'images/properties/' . Str::random(10) . '.jpg'; // Génère un nom de fichier aléatoire
                $image = Image::make($faker->imageUrl())->encode('jpg', 80); // Génère une image à partir de l'URL aléatoire
                Storage::disk('public')->put($imagePath, $image); // Sauvegarde l'image dans le dossier public

                $images[] = $imagePath;
            }

            // $bienImmobilier = [
                $property -> id_user = $faker->numberBetween(1, 1);
                $property -> propertyName = $faker->word;
                $property -> propertyType = $faker->randomElement(['Appartement', 'Maison', 'Villa']);
                $property -> propertyStatus = $faker->randomElement(['A vendre', 'A louer']);
                $property -> bedrooms = $faker->numberBetween(1, 5);
                $property -> bathrooms = $faker->numberBetween(1, 3);
                $property -> area = $faker->numberBetween(50, 200);
                $property -> price = $faker->numberBetween(100000, 500000);
                $property -> country = $faker->country;
                $property -> city = $faker->city;
                $property -> description = $faker->paragraph;
                $property -> images = json_encode($images);
                $property -> contactName = $faker->name;
                $property -> contactEmail = $faker->email;
                $property -> contactPhone = $faker->phoneNumber;
            // ];

            $property -> save();

            $properties[] = $property;
        }



        return response() -> json($properties);


    }

    //Gestion des vues de proprietes
    public function viewProperties (Request $request, Propertie $property)
    {
        $property = Propertie::where('id',$property -> id) -> get();

        // $property->update($request->except(['views']));


        // $i = $property -> views;
        $property[0] -> views += 1;

        $property[0] -> save();
        return response() -> json($property);
    }

    //validation d'une propriete
    public function validateProperty (Request $request, Propertie $property){

        $property -> update($request -> except('active'));

        $property -> active = "true";

        $property -> save();

    }

    //select properties of user

    public function PropertiesUser (Request $request, $id){

        $propertiesUser = Propertie::where('id_user', $id ) -> get();

        return response() -> json($propertiesUser);

    }
}

