<?php

namespace App\Http\Controllers;

use App\Models\InfosUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\Response;

class InfosUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InfosUser::select('id','sexe','nationalité','date_de_naissance', 'lieu_de_residence', 'entreprise', 'site_internet', 'image')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sexe' => 'required',
            'nationalité' => 'required',
            'date_de_naissance' => 'required',
            'lieu_de_residence' => 'required',
            'entreprise' => 'required',
            'site_internet' => 'required',
            'image' => 'required|image',
            'profil' => 'required|image' // Ajoutez la validation pour le champ "profil"
        ]);

        try {
            $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('InfosUser/image', $request->image, $imageName);

            $profilImageName = Str::random().'.'.$request->profil->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('InfosUser/profil', $request->profil, $profilImageName);

            InfosUser::create($request->post() + [
                'image' => $imageName,
                'profil' => $profilImageName // Stockez le nom de l'image de profil dans le champ "profil"
            ]);

            return response()->json([
                'message' => 'InfosUser saved successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong while creating an InfosUser!'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InfosUser $infosUser): Response
    {
        return response()->json([
            'InfosUser'=>$infosUser
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfosUser $infosUser): Response
    {
        //
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InfosUser  $InfosUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InfosUser $infosUser)
    {
        try {
            $request->validate([
                'sexe' => 'required',
                'nationalité' => 'required',
                'date_de_naissance' => 'required',
                'lieu_de_residence' => 'required',
                'entreprise' => 'required',
                'site_internet' => 'required',
                'image' => 'nullable|image',
                'profil' => 'nullable|image' // Ajoutez la validation pour le champ "profil"
            ]);

            // Mettre à jour les informations de l'utilisateur
            $infosUser->update($request->except(['image', 'profil']));

            // Mettre à jour l'image associée, le cas échéant
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image, le cas échéant
                if ($infosUser->image) {
                    $exists = Storage::disk('public')->exists("InfosUser/image/{$infosUser->image}");
                    if ($exists) {
                        Storage::disk('public')->delete("InfosUser/image/{$infosUser->image}");
                    }
                }

                // Enregistrer la nouvelle image
                $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('InfosUser/image', $request->image, $imageName);

                // Mettre à jour le nom de l'image dans le modèle
                $infosUser->image = $imageName;
            }

            // Mettre à jour l'image de profil, le cas échéant
            if ($request->hasFile('profil')) {
                // Supprimer l'ancienne image de profil, le cas échéant
                if ($infosUser->profil) {
                    $exists = Storage::disk('public')->exists("InfosUser/profil/{$infosUser->profil}");
                    if ($exists) {
                        Storage::disk('public')->delete("InfosUser/profil/{$infosUser->profil}");
                    }
                }

                // Enregistrer la nouvelle image de profil
                $profilImageName = Str::random().'.'.$request->profil->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('InfosUser/profil', $request->profil, $profilImageName);

                // Mettre à jour le nom de l'image de profil dans le modèle
                $infosUser->profil = $profilImageName;
            }

            $infosUser->save();

            return response()->json([
                'message' => 'InfosUser updated successfully!'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong while updating an InfosUser!',
                'errors' => $e->errors(),
                'exception' => $e
            ], 500);
        }
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InfosUser  $InfosUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(InfosUser $infosUser)
    {
        try {
            // Supprimer l'image associée, le cas échéant
            if ($infosUser->image) {
                $exists = Storage::disk('public')->exists("InfosUser/image/{$infosUser->image}");
                if ($exists) {
                    Storage::disk('public')->delete("InfosUser/image/{$infosUser->image}");
                }
            }

            // Supprimer l'image de profil associée, le cas échéant
            if ($infosUser->profil) {
                $exists = Storage::disk('public')->exists("InfosUser/profil/{$infosUser->profil}");
                if ($exists) {
                    Storage::disk('public')->delete("InfosUser/profil/{$infosUser->profil}");
                }
            }

            // Supprimer l'utilisateur
            $infosUser->delete();

            return response()->json([
                'message' => 'InfosUser Deleted Successfully!!'
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while deleting an InfosUser!!'
            ], 500);
        }
    }
}
