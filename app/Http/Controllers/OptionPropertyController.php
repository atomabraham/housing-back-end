<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class OptionPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = Option::all();

        return response() -> json($options);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request -> validate([
            'name' => 'required'
        ]);

        $option = Option::create([
            'name' => $data['name']
        ]);

        return response() -> json([$option]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Option $option)
    {
        $id = $request -> validate([
            'id' => 'required'
        ]);

        $option = Option :: where('id', $id) -> get();

        return response() -> json($option);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request -> validate([
            'name' => 'required'
        ]);

        $request -> update([
            'name' => $data['name']
        ]);

        return response() -> json([$option]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Option $option)
    {
        $id = $request -> validate([
            'id' => 'required'
        ]);

        $option = Option :: where('id', $id) -> delete();


        return response() -> json([],200);
    }
}
