<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Propertie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Propertie::all();

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
            'image' => 'required|image',
            'contactName' => 'required',
            'contactEmail' => 'required',
            'contactEmail' => 'required',
            'contactPhone' => 'required',
        ]);

        try {
            $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images/properties', $request->image,$imageName);
            Propertie::create($request->post()+['image'=>$imageName]);

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
    public function destroy(string $id)
    {
        //
    }
}
